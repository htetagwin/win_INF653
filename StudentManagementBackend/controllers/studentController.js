const Student = require('../models/Student');

// Create a new student and save to the database
const createStudent = async (req, res) => {
  try {
    const { firstName, lastName, email, course, enrolledDate } = req.body;
    const student = new Student({ firstName, lastName, email, course, enrolledDate });
    await student.save();
    res.status(201).json(student); // Respond with created student
  } catch (error) {
    res.status(400).json({ message: error.message }); // Handle validation or save errors
  }
};

module.exports = {
  // Get all student records
  getStudents: async (req, res) => {
    const students = await Student.find();
    res.json(students);
  },

  // Get a single student by ID
  getStudentById: async (req, res) => {
    const student = await Student.findById(req.params.id);
    res.json(student);
  },

  // Create student (shared from above)
  createStudent,

  // Update student record by ID
  updateStudent: async (req, res) => {
    const student = await Student.findByIdAndUpdate(req.params.id, req.body, { new: true });
    res.json(student);
  },

  // Delete a student by ID
  deleteStudent: async (req, res) => {
    await Student.findByIdAndDelete(req.params.id);
    res.json({ message: 'Student deleted' });
  }
};
