# Smart To-Do List API

A Laravel-based Task Management API that features intelligent title parsing, goal tracking, and comprehensive automated testing.

## 🚀 Key Features

* **Intelligent Task Parsing**: Automatically detects priority (e.g., `#urgent`) and due dates (e.g., `tomorrow`) directly from the task title.
* **Goal Management**: Tasks are organized under specific user goals.
* **Secure API**: Full authentication and authorization logic to ensure users only access their own data.
*  **Text Processing**: Uses a custom parsing engine to extract priority levels and dates from natural language input.

## 🧪 Testing Suite

This project follows high-quality standards with a complete testing suite:
* **Unit Tests**: Focused on the core logic (Parsing engine).
* **Feature Tests**: Testing API lifecycle, Authentication, and Security.

To run the tests:
```bash
php artisan test
