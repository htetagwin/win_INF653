const express = require('express');
const router = express.Router();
const { getEvents, getCategories, getEventById, createEvent, updateEvent, deleteEvent } = require('../controllers/eventController');
const auth = require('../middleware/auth');

router.get('/', getEvents);
router.get('/categories', getCategories);
router.get('/:id', getEventById);
router.post('/', auth(['admin']), createEvent);
router.put('/:id', auth(['admin']), updateEvent);
router.delete('/:id', auth(['admin']), deleteEvent);

module.exports = router;