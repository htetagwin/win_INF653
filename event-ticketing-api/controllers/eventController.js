const Event = require('../models/Event');
const Booking = require('../models/Booking');
const mongoose = require('mongoose');

// Get all events with filtering
const getEvents = async (req, res) => {
  const { category, venue, startDate, endDate, sort = 'date' } = req.query; // Changed from req.body to req.query
  const query = {};
  if (category) query.category = new RegExp(category, 'i');
  if (venue) query.venue = new RegExp(venue, 'i');
  if (startDate || endDate) {
    query.date = {};
    if (startDate) query.date.$gte = new Date(startDate);
    if (endDate) query.date.$lte = new Date(new Date(endDate).setHours(23, 59, 59, 999));
  }
  try {
    const events = await Event.find(query).sort(sort);
    res.json(events);
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

// Get unique event categories
const getCategories = async (req, res) => {
  try {
    const categories = await Event.distinct('category');
    res.json(categories.filter(cat => cat));
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

// Get event by ID
const getEventById = async (req, res) => {
  try {
    const event = await Event.findById(req.params.id);
    if (!event) {
      return res.status(404).json({ error: 'Event not found' });
    }
    res.json(event);
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

// Create a new event
const createEvent = async (req, res) => {
  const { title, description, category, venue, date, time, seatCapacity, price } = req.body;
  if (!title || !date || !seatCapacity || !price) {
    return res.status(400).json({ error: 'Required fields missing' });
  }
  try {
    const event = new Event({ title, description, category, venue, date, time, seatCapacity, price, bookedSeats: 0 });
    await event.save();
    res.status(201).json(event);
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

// Update an existing event
const updateEvent = async (req, res) => {
  const { title, description, category, venue, date, time, seatCapacity, price } = req.body;
  try {
    const event = await Event.findById(req.params.id);
    if (!event) {
      return res.status(404).json({ error: 'Event not found' });
    }
    if (seatCapacity && seatCapacity < event.bookedSeats) {
      return res.status(400).json({ error: 'Cannot reduce capacity below booked seats' });
    }
    event.title = title || event.title;
    event.description = description || event.description;
    event.category = category || event.category;
    event.venue = venue || event.venue;
    event.date = date || event.date;
    event.time = time || event.time;
    event.seatCapacity = seatCapacity || event.seatCapacity;
    event.price = price || event.price;
    await event.save();
    res.json(event);
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

// Delete an event
const deleteEvent = async (req, res) => {
  try {
    if (!mongoose.Types.ObjectId.isValid(req.params.id)) {
      return res.status(400).json({ error: 'Invalid event ID' });
    }
    const event = await Event.findById(req.params.id);
    if (!event) {
      return res.status(404).json({ error: 'Event not found' });
    }
    const bookings = await Booking.find({ event: req.params.id });
    if (bookings.length > 0) {
      return res.status(400).json({ error: 'Cannot delete event with bookings' });
    }
    await Event.deleteOne({ _id: req.params.id });
    res.json({ message: 'Event deleted' });
  } catch (error) {
    res.status(500).json({ error: 'Server error' });
  }
};

module.exports = { getEvents, getCategories, getEventById, createEvent, updateEvent, deleteEvent };