Event Ticketing System API
A simple API for booking event tickets.
Setup Instructions

Get the Code:
git clone <https://github.com/htetagwin/win_INF653>
cd event-ticketing-api


Install Tools:
npm install


Add Secrets:

Create a .env file with:PORT=3000
MONGO_URI=your-mongodb-link
JWT_SECRET=your-secret-word


Get your-mongodb-link from MongoDB Atlas.
Use a random word for your-secret-word.


Start the API:
npm start


Visit http://localhost:3000.



API Reference
Base URL: http://localhost:3000/
Sign Up and Log In

POST /api/auth/register

Send: { "name": "John", "email": "john@example.com", "password": "pass123" }
Get: { "message": "User registered successfully" }


POST /api/auth/login

Send: { "email": "john@example.com", "password": "pass123" }
Get: { "token": "token-string" }



Events

GET /api/events

Filters: category=Concert, venue=Arena, startDate=2025-06-01, endDate=2025-06-30
Example: /api/events?category=Concert
Get: List of events


GET /api/events/categories

Get: List of categories


GET /api/events/:id

Get: Event details


POST /api/events

Send: { "title": "Concert", "category": "Music", "venue": "Arena", "date": "2025-06-01", "seatCapacity": 100, "price": 50 }
Header: Authorization: Bearer admin-token
Get: New event


PUT /api/events/:id

Send: { "title": "New Title" }
Header: Authorization: Bearer admin-token
Get: Updated event


DELETE /api/events/:id

Header: Authorization: Bearer admin-token
Get: { "message": "Event deleted" }



Bookings

POST /api/bookings

Send: { "eventId": "event-id", "quantity": 2 }
Header: Authorization: Bearer user-token
Get: Booking details


GET /api/bookings

Header: Authorization: Bearer user-token
Get: List of bookings


GET /api/bookings/:id

Header: Authorization: Bearer user-token
Get: Booking details