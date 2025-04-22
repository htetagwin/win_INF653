const express = require('express');
const dotenv = require('dotenv');
const mongoose = require('mongoose');
const studentRoutes = require('./routes/studentRoutes');
const connectDB = require('./dbConfig');

dotenv.config();
connectDB();

const app = express();

// MIDDLEWARE
app.use(express.json()); // 🔸 Needed to parse JSON requests!

// ROUTES
app.use('/students', studentRoutes);

const PORT = process.env.PORT || 5050;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
