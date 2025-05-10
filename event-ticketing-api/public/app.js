const API_BASE_URL = '/api';
const authSection = document.getElementById('auth-section');
const userView = document.getElementById('user-view');
const adminView = document.getElementById('admin-view');
const authStatus = document.getElementById('auth-status');
const logoutBtn = document.getElementById('logout-btn');
const registerForm = document.getElementById('register');
const loginForm = document.getElementById('login');
const registerError = document.getElementById('register-error');
const loginError = document.getElementById('login-error');
const filterBtn = document.getElementById('filter-btn');
const clearFilterBtn = document.getElementById('clear-filter-btn');
const filterCategory = document.getElementById('filter-category');
const filterVenue = document.getElementById('filter-venue');
const filterStartDate = document.getElementById('filter-start-date');
const filterEndDate = document.getElementById('filter-end-date');
const filterFeedback = document.getElementById('filter-feedback');
const filterSpinner = document.getElementById('filter-spinner');
const eventsList = document.getElementById('events-list');
const bookTicketsForm = document.getElementById('book-tickets');
const bookError = document.getElementById('book-error');
const bookingsList = document.getElementById('bookings-list');
const createEventForm = document.getElementById('create-event');
const createError = document.getElementById('create-error');
const adminEventsList = document.getElementById('admin-events-list');

// Utility function for API calls
async function apiCall(endpoint, method = 'GET', body = null, token = null) {
  const headers = { 'Content-Type': 'application/json' };
  if (token) headers['Authorization'] = `Bearer ${token}`;
  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      method,
      headers,
      body: body ? JSON.stringify(body) : null,
    });
    return await response.json();
  } catch (error) {
    console.error('API call error:', error);
    return { error: 'Network error' };
  }
}

// Debounce function to limit API calls
function debounce(func, wait) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  };
}

// Check authentication status
function checkAuth() {
  const token = localStorage.getItem('token');
  if (!token) {
    authStatus.textContent = 'Please log in or register.';
    authSection.classList.remove('hidden');
    userView.classList.add('hidden');
    adminView.classList.add('hidden');
    logoutBtn.classList.add('hidden');
    return;
  }
  try {
    const payload = JSON.parse(atob(token.split('.')[1]));
    authStatus.textContent = `Logged in as ${payload.role}`;
    logoutBtn.classList.remove('hidden');
    authSection.classList.add('hidden');
    if (payload.role === 'admin') {
      adminView.classList.remove('hidden');
      userView.classList.add('hidden');
      loadAdminEvents();
    } else {
      userView.classList.remove('hidden');
      adminView.classList.add('hidden');
      loadEvents();
      loadBookings();
      loadCategories();
    }
  } catch (error) {
    console.error('Invalid token:', error);
    localStorage.removeItem('token');
    checkAuth();
  }
}

// Load categories for dropdown
async function loadCategories() {
  const categories = await apiCall('/events/categories');
  filterCategory.innerHTML = '<option value="">All Categories</option>' +
    categories.map(cat => `<option value="${cat}">${cat}</option>`).join('');
}

// Load events with filters
async function loadEvents(category = '', venue = '', startDate = '', endDate = '') {
  if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
    filterFeedback.textContent = 'Error: End date must be after start date.';
    return;
  }
  filterSpinner.classList.remove('hidden');
  const query = new URLSearchParams();
  if (category) query.set('category', category);
  if (venue) query.set('venue', venue);
  if (startDate) query.set('startDate', startDate);
  if (endDate) query.set('endDate', endDate);
  query.set('sort', 'date');
  const events = await apiCall(`/events?${query}`);
  filterSpinner.classList.add('hidden');

  // Update feedback
  const filters = [];
  if (category) filters.push(`Category: ${category}`);
  if (venue) filters.push(`Venue: ${venue}`);
  if (startDate) filters.push(`From: ${new Date(startDate).toLocaleDateString()}`);
  if (endDate) filters.push(`To: ${new Date(endDate).toLocaleDateString()}`);
  filterFeedback.textContent = events.length
    ? `Found ${events.length} event${events.length === 1 ? '' : 's'}${filters.length ? ' for ' + filters.join(', ') : ''}`
    : 'No events found for the selected filters.';

  eventsList.innerHTML = events.map(event => `
    <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
      <h3 class="font-bold text-lg mb-2">${event.title}</h3>
      <p class="text-gray-700"><strong>Description:</strong> ${event.description || 'N/A'}</p>
      <p class="text-gray-700"><strong>Category:</strong> ${event.category || 'N/A'}</p>
      <p class="text-gray-700"><strong>Venue:</strong> ${event.venue || 'N/A'}</p>
      <p class="text-gray-700"><strong>Date:</strong> ${new Date(event.date).toLocaleDateString()}</p>
      <p class="text-gray-700"><strong>Time:</strong> ${event.time || 'N/A'}</p>
      <p class="text-gray-700"><strong>Seats Available:</strong> ${event.seatCapacity - event.bookedSeats}</p>
      <p class="text-gray-700"><strong>Total Seats:</strong> ${event.seatCapacity}</p>
      <p class="text-gray-700"><strong>Booked Seats:</strong> ${event.bookedSeats}</p>
      <p class="text-gray-700"><strong>Price:</strong> $${event.price.toFixed(2)}</p>
      <p class="text-gray-500 text-sm"><strong>ID:</strong> ${event._id}</p>
    </div>
  `).join('');
}

// Load admin events
async function loadAdminEvents() {
  const events = await apiCall('/events');
  adminEventsList.innerHTML = events.map(event => `
    <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
      <h3 class="font-bold text-lg mb-2">${event.title}</h3>
      <p class="text-gray-700"><strong>Description:</strong> ${event.description || 'N/A'}</p>
      <p class="text-gray-700"><strong>Category:</strong> ${event.category || 'N/A'}</p>
      <p class="text-gray-700"><strong>Venue:</strong> ${event.venue || 'N/A'}</p>
      <p class="text-gray-700"><strong>Date:</strong> ${new Date(event.date).toLocaleDateString()}</p>
      <p class="text-gray-700"><strong>Time:</strong> ${event.time || 'N/A'}</p>
      <p class="text-gray-700"><strong>Seats Available:</strong> ${event.seatCapacity - event.bookedSeats}</p>
      <p class="text-gray-700"><strong>Total Seats:</strong> ${event.seatCapacity}</p>
      <p class="text-gray-700"><strong>Booked Seats:</strong> ${event.bookedSeats}</p>
      <p class="text-gray-700"><strong>Price:</strong> $${event.price.toFixed(2)}</p>
      <p class="text-gray-500 text-sm"><strong>ID:</strong> ${event._id}</p>
      <div class="mt-4 flex gap-2">
        <button onclick="populateUpdateForm('${event._id}', '${event.title.replace(/'/g, "\\'")}', '${(event.description || '').replace(/'/g, "\\'")}', '${(event.category || '').replace(/'/g, "\\'")}', '${(event.venue || '').replace(/'/g, "\\'")}', '${new Date(event.date).toISOString().split('T')[0]}', '${(event.time || '').replace(/'/g, "\\'")}', ${event.seatCapacity}, ${event.price})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
        <button onclick="deleteEvent('${event._id}')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
      </div>
    </div>
  `).join('');
}

// Load user bookings
async function loadBookings() {
  const token = localStorage.getItem('token');
  const bookings = await apiCall('/bookings', 'GET', null, token);
  bookingsList.innerHTML = bookings.map(booking => `
    <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
      <p class="text-gray-700"><strong>Event:</strong> ${booking.event.title}</p>
      <p class="text-gray-700"><strong>Quantity:</strong> ${booking.quantity}</p>
      <p class="text-gray-700"><strong>Booking Date:</strong> ${new Date(booking.bookingDate).toLocaleString()}</p>
    </div>
  `).join('');
}

// Delete an event
async function deleteEvent(id) {
  const token = localStorage.getItem('token');
  try {
    const response = await apiCall(`/events/${id}`, 'DELETE', null, token);
    if (response.message) {
      createError.textContent = 'Event deleted!';
      loadAdminEvents();
    } else {
      createError.textContent = response.error || response.details || 'Deletion failed.';
    }
  } catch (error) {
    createError.textContent = 'Failed to delete event: ' + error.message;
    console.error('Client-side delete event error:', error);
  }
}

// Populate update form
function populateUpdateForm(id, title, description, category, venue, date, time, seatCapacity, price) {
  document.getElementById('event-id').value = id;
  document.getElementById('event-title').value = title;
  document.getElementById('event-description').value = description;
  document.getElementById('event-category').value = category;
  document.getElementById('event-venue').value = venue;
  document.getElementById('event-date').value = date;
  document.getElementById('event-time').value = time;
  document.getElementById('event-seatCapacity').value = seatCapacity;
  document.getElementById('event-price').value = price;
  document.getElementById('event-submit-btn').textContent = 'Update';
}

// Handle create or update event
async function handleEventSubmit(e) {
  e.preventDefault();
  const token = localStorage.getItem('token');
  const eventId = document.getElementById('event-id').value;
  const body = {
    title: document.getElementById('event-title').value,
    description: document.getElementById('event-description').value,
    category: document.getElementById('event-category').value,
    venue: document.getElementById('event-venue').value,
    date: document.getElementById('event-date').value,
    time: document.getElementById('event-time').value,
    seatCapacity: parseInt(document.getElementById('event-seatCapacity').value),
    price: parseFloat(document.getElementById('event-price').value),
  };

  const isUpdate = !!eventId;
  const method = isUpdate ? 'PUT' : 'POST';
  const endpoint = isUpdate ? `/events/${eventId}` : '/events';
  const response = await apiCall(endpoint, method, body, token);

  if (response._id) {
    createError.textContent = isUpdate ? 'Event updated!' : 'Event created!';
    createEventForm.reset();
    document.getElementById('event-id').value = '';
    document.getElementById('event-submit-btn').textContent = 'Create';
    loadAdminEvents();
  } else {
    createError.textContent = response.error || (isUpdate ? 'Update failed.' : 'Creation failed.');
  }
}

// Event listeners
registerForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const name = document.getElementById('reg-name').value;
  const email = document.getElementById('reg-email').value;
  const password = document.getElementById('reg-password').value;
  const response = await apiCall('/auth/register', 'POST', { name, email, password });
  if (response.message) {
    registerError.textContent = 'Registration successful! Please log in.';
    registerForm.reset();
  } else {
    registerError.textContent = response.error || 'Registration failed.';
  }
});

loginForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const email = document.getElementById('login-email').value;
  const password = document.getElementById('login-password').value;
  const response = await apiCall('/auth/login', 'POST', { email, password });
  if (response.token) {
    localStorage.setItem('token', response.token);
    loginError.textContent = 'Login successful!';
    loginForm.reset();
    checkAuth();
  } else {
    loginError.textContent = response.error || 'Login failed.';
  }
});

logoutBtn.addEventListener('click', () => {
  localStorage.removeItem('token');
  checkAuth();
});

const debouncedLoadEvents = debounce(loadEvents, 300);

filterBtn.addEventListener('click', () => {
  const category = filterCategory.value;
  const venue = filterVenue.value;
  const startDate = filterStartDate.value;
  const endDate = filterEndDate.value;
  debouncedLoadEvents(category, venue, startDate, endDate);
});

clearFilterBtn.addEventListener('click', () => {
  filterCategory.value = '';
  filterVenue.value = '';
  filterStartDate.value = '';
  filterEndDate.value = '';
  filterFeedback.textContent = '';
  loadEvents();
});

bookTicketsForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const eventId = document.getElementById('book-event-id').value;
  const quantity = parseInt(document.getElementById('book-quantity').value);
  const token = localStorage.getItem('token');
  const response = await apiCall('/bookings', 'POST', { eventId, quantity }, token);
  if (response._id) {
    bookError.textContent = 'Booking successful!';
    bookTicketsForm.reset();
    loadBookings();
  } else {
    bookError.textContent = response.error || 'Booking failed.';
  }
});

createEventForm.addEventListener('submit', handleEventSubmit);

// Initialize
checkAuth();