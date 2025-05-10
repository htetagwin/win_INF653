const express = require('express');
const router = express.Router();
const { createBooking, getBookings, getBookingById } = require('../controllers/bookingController');
const auth = require('../middleware/auth');

router.post('/', auth(['user']), createBooking);
router.get('/', auth(['user']), getBookings);
router.get('/:id', auth(['user']), getBookingById);

module.exports = router;