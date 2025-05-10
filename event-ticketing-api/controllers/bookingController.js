const Booking = require('../models/Booking');
const Event = require('../models/Event');

// Create a new booking for an event
const createBooking = async (req, res) => {
  const { eventId, quantity } = req.body;

  // Validate required fields
  if (!eventId || !quantity) {
    return res.status(400).json({ error: 'Event ID and quantity required' });
  }

  try {
    // Find event by ID
    const event = await Event.findById(eventId);
    if (!event) {
      return res.status(404).json({ error: 'Event not found' });
    }

    // Check seat availability
    if (event.seatCapacity - event.bookedSeats < quantity) {
      return res.status(400).json({ error: 'Not enough seats available' });
    }

    // Create new booking
    const booking = new Booking({
      user: req.user.id,
      event: eventId,
      quantity,
    });

    // Save booking
    await booking.save();

    // Update event's booked seats
    event.bookedSeats += quantity;
    await event.save();

    res.status(201).json(booking);
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

// Get all bookings for the authenticated user
const getBookings = async (req, res) => {
  try {
    // Find bookings for user and populate event details
    const bookings = await Booking.find({ user: req.user.id }).populate('event');
    res.json(bookings);
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

// Get a specific booking by ID
const getBookingById = async (req, res) => {
  try {
    // Find booking by ID and populate event details
    const booking = await Booking.findById(req.params.id).populate('event');
    if (!booking) {
      return res.status(404).json({ error: 'Booking not found' });
    }

    // Verify user ownership
    if (booking.user.toString() !== req.user.id) {
      return res.status(403).json({ error: 'Access denied' });
    }

    res.json(booking);
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

module.exports = { createBooking, getBookings, getBookingById };