# API Documentation - Safae Laravel

## Base URL
```
http://localhost:8000/api
```

## Authentication
Gunakan Laravel Sanctum dengan Bearer Token. Setelah login/register, simpan token dan kirim di header:
```
Authorization: Bearer {your-token-here}
```

---

## 🔐 Authentication Endpoints

### Register
```http
POST /api/register
```
**Body:**
```json
{
  "nama_depan": "John",
  "nama_belakang": "Doe",
  "username": "johndoe",
  "email": "john@example.com",
  "telepon": "08123456789",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### Login
```http
POST /api/login
```
**Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

### Get Profile
```http
GET /api/profile
Authorization: Bearer {token}
```

### Update Profile
```http
PUT /api/profile
Authorization: Bearer {token}
```
**Body:**
```json
{
  "nama_depan": "John",
  "email": "newemail@example.com",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

---

## 📚 Book Endpoints

### Get All Books (with filters)
```http
GET /api/books?per_page=15&search=harry&genre=fantasy&status=available
```

### Get Book Details
```http
GET /api/books/{id}
```

### Get Popular Books
```http
GET /api/books/popular/list
```

### Get Latest Books
```http
GET /api/books/latest/list
```

### Create Book (Admin)
```http
POST /api/books
Authorization: Bearer {token}
Content-Type: multipart/form-data
```
**Body (form-data):**
- title: "Book Title"
- author: "Author Name"
- genre: "Fiction"
- year: 2024
- description: "Book description"
- status: "available"
- content: "Book content"
- image: [file]

### Update Book (Admin)
```http
PUT /api/books/{id}
Authorization: Bearer {token}
```

### Delete Book (Admin)
```http
DELETE /api/books/{id}
Authorization: Bearer {token}
```

---

## 🏷️ Genre & Topic Endpoints

### Get All Genres
```http
GET /api/genres
```

### Get Genre with Topics
```http
GET /api/genres/{id}
```

### Create Genre (Admin)
```http
POST /api/genres
Authorization: Bearer {token}
```
**Body:**
```json
{
  "nama_genre": "Science Fiction"
}
```

### Get All Topics
```http
GET /api/topics?per_page=15&genre_id=1
```

### Create Topic
```http
POST /api/topics
Authorization: Bearer {token}
Content-Type: multipart/form-data
```
**Body (form-data):**
- genre_id: 1
- judul: "Topic Title"
- isi: "Topic content"
- gambar: [file] (optional)
- file: [file] (optional)

---

## ⭐ Review & Comment Endpoints

### Get Reviews for Book
```http
GET /api/reviews?book_id=1
```

### Get My Reviews
```http
GET /api/reviews/my/list
Authorization: Bearer {token}
```

### Create Review
```http
POST /api/reviews
Authorization: Bearer {token}
```
**Body:**
```json
{
  "book_id": 1,
  "rating": 5,
  "komentar": "Great book!"
}
```

### Update Review
```http
PUT /api/reviews/{id}
Authorization: Bearer {token}
```

### Delete Review
```http
DELETE /api/reviews/{id}
Authorization: Bearer {token}
```

### Comments (similar pattern)
```http
GET /api/comments?topic_id=1
POST /api/comments
PUT /api/comments/{id}
DELETE /api/comments/{id}
```

---

## 📖 Reading History & Progress Endpoints

### Get Reading History
```http
GET /api/reading/history
Authorization: Bearer {token}
```

### Get Reading History for Specific Book
```http
GET /api/reading/history/book/{bookId}
Authorization: Bearer {token}
```

### Update Reading History
```http
POST /api/reading/history
Authorization: Bearer {token}
Content-Type: multipart/form-data
```
**Body:**
```json
{
  "book_id": 1,
  "progress": 75,
  "bukti_progress": [file]
}
```

### Get Reading Progress
```http
GET /api/reading/progress
Authorization: Bearer {token}
```

### Record Reading Duration
```http
POST /api/reading/progress
Authorization: Bearer {token}
```
**Body:**
```json
{
  "book_id": 1,
  "duration": 3600
}
```

### Get Total Duration
```http
GET /api/reading/duration?book_id=1
Authorization: Bearer {token}
```

---

## ❤️ Favorite Endpoints

### Get Favorites
```http
GET /api/favorites
Authorization: Bearer {token}
```

### Add to Favorites
```http
POST /api/favorites
Authorization: Bearer {token}
```
**Body:**
```json
{
  "book_id": 1
}
```

### Remove from Favorites
```http
DELETE /api/favorites/{id}
Authorization: Bearer {token}
```

### Check Favorite Status
```http
GET /api/favorites/check/{bookId}
Authorization: Bearer {token}
```

---

## 🎯 Point Endpoints

### Get Point History
```http
GET /api/points/history
Authorization: Bearer {token}
```

### Get Total Points
```http
GET /api/points/total
Authorization: Bearer {token}
```

### Add Points
```http
POST /api/points/add
Authorization: Bearer {token}
```
**Body:**
```json
{
  "points": 100,
  "user_id": 1
}
```

### Deduct Points
```http
POST /api/points/deduct
Authorization: Bearer {token}
```
**Body:**
```json
{
  "points": 50
}
```

### Get Leaderboard
```http
GET /api/points/leaderboard?limit=10
```

---

## 🔔 Notification Endpoints

### Get All Notifications
```http
GET /api/notifications
Authorization: Bearer {token}
```

### Get Unread Notifications
```http
GET /api/notifications/unread
Authorization: Bearer {token}
```

### Get Unread Count
```http
GET /api/notifications/unread/count
Authorization: Bearer {token}
```

### Mark as Read
```http
PUT /api/notifications/{id}/read
Authorization: Bearer {token}
```

### Mark All as Read
```http
PUT /api/notifications/read/all
Authorization: Bearer {token}
```

---

## 💳 Payment Endpoints

### Get Payment History
```http
GET /api/payments
Authorization: Bearer {token}
```

### Create Payment (Purchase Points)
```http
POST /api/payments
Authorization: Bearer {token}
```
**Body:**
```json
{
  "points": 1000,
  "price": 50000,
  "metode": "transfer"
}
```

### Get Payment Statistics (Admin)
```http
GET /api/payments/admin/statistics
Authorization: Bearer {token}
```

---

## 📧 Contact Endpoints

### Submit Contact Message
```http
POST /api/contact
```
**Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "message": "Hello, I need help..."
}
```

### Get All Contact Messages (Admin)
```http
GET /api/contacts
Authorization: Bearer {token}
```

---

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": { ... }
}
```

---

## Testing dengan Thunder Client / Postman

1. Import collection atau buat request baru
2. Set Base URL: `http://localhost:8000/api`
3. Untuk protected routes:
   - Login terlebih dahulu
   - Copy token dari response
   - Tambahkan di Header: `Authorization: Bearer {token}`

## CORS Configuration

Jika akan diakses dari Flutter, tambahkan CORS middleware atau gunakan package `fruitcake/laravel-cors`.
