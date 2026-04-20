# Rental Booking System API

Laravel-based rental booking system with authentication, role-based authorization, CRUD APIs, seed data, queue-driven email notifications, API resources, and feature tests.

## Implemented Requirements

- Authentication and authorization
  - User registration and login with Laravel Sanctum tokens
  - Role-based access control for `admin`, `owner`, and `customer`
  - Policies for property, booking, and review actions
- CRUD operations
  - Major entities: `users`, `properties`, `bookings`, `reviews`, `categories`, `amenities`
  - Relationships:
    - `User -> hasMany -> Property`
    - `User -> hasMany -> Booking`
    - `Property -> belongsToMany -> Amenity` via `amenity_property`
    - `Property -> belongsTo -> Category`
    - `Booking -> hasOne -> Review`
- Validation and error handling
  - Dedicated Form Requests for auth, properties, bookings, and reviews
  - Consistent JSON validation errors and custom messages for key invalid cases
- Migrations and seeders
  - Migrations for all entities and pivot table
  - Seeders for roles, demo users, categories, amenities, properties, and bookings
- API documentation
  - Endpoint list and example payloads in this README
- Testing
  - Feature tests for auth, role checks, booking overlap logic, and review rules
- Laravel best practices and advanced features
  - Sanctum token auth
  - Policies and middleware aliases
  - API Resource classes
  - Service class with dependency injection
  - Events, listeners, and queued email sending
  - Pivot table for amenities

## Tech Notes

- Framework: Laravel 13
- Auth: Laravel Sanctum
- Test runner: Pest
- Test database: in-memory SQLite via `.env.testing`
- Queue in testing: `sync`

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

For development with queue worker and Vite:

```bash
composer run dev
```

## Seeded Accounts

All seeded users use password `password`.

- `admin@example.com` - admin
- `owner@example.com` - owner
- `user1@example.com` - customer
- `user2@example.com` - customer

## API Authentication

Use the returned Sanctum token in the `Authorization` header:

```http
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

## Endpoints

### Auth

- `POST /api/register`
- `POST /api/login`
- `GET /api/me`
- `POST /api/logout`

Example register payload:

```json
{
  "name": "Owner User",
  "email": "owner2@example.com",
  "password": "password",
  "password_confirmation": "password",
  "role": "owner",
  "device_name": "postman"
}
```

### Properties

- `GET /api/properties`
- `GET /api/properties/{id}`
- `POST /api/properties` - owner/admin only
- `PUT /api/properties/{id}` - owner/admin only, policy-protected
- `PATCH /api/properties/{id}` - owner/admin only, policy-protected
- `DELETE /api/properties/{id}` - owner/admin only, policy-protected

Example create property payload:

```json
{
  "title": "Central Apartment",
  "description": "Two-bedroom apartment close to downtown.",
  "address": "123 Main Street",
  "price_per_night": 120,
  "max_guests": 4,
  "category_id": 1,
  "amenities": [1, 2, 3]
}
```

### Bookings

- `GET /api/bookings`
  - admin sees all bookings
  - regular users see only their own
- `POST /api/bookings`
- `GET /api/bookings/{id}`
- `PATCH /api/bookings/{id}/cancel`

Example create booking payload:

```json
{
  "property_id": 1,
  "start_date": "2026-05-01",
  "end_date": "2026-05-05"
}
```

### Reviews

- `POST /api/reviews`
- `PUT /api/reviews/{id}`
- `PATCH /api/reviews/{id}`
- `DELETE /api/reviews/{id}`

Users can review only their own completed booking, and only once per booking.

Example review payload:

```json
{
  "booking_id": 1,
  "rating": 5,
  "comment": "Great stay and very clean apartment."
}
```

## Queues, Events, and Notifications

When a booking is created:

1. `BookingCreated` event is dispatched.
2. `SendBookingConfirmationEmail` listener handles the event.
3. The listener is queueable and sends the `BookingConfirmed` email.

To process queue jobs outside tests:

```bash
php artisan queue:work
```

## Running Tests

```bash
php artisan test
```

## Project Structure Highlights

- `app/Http/Controllers/Api` - API controllers
- `app/Http/Requests/Api` - Form Request validation
- `app/Http/Resources` - JSON response shaping
- `app/Policies` - authorization logic
- `app/Services/BookingService.php` - booking creation business logic
- `app/Events` and `app/Listeners` - event-driven booking flow
- `database/seeders` - essential seed data

## Suggested Demo Flow

1. Register or log in as an `owner`.
2. Create a property.
3. Log in as a `customer`.
4. Book the property.
5. After the booking dates pass, create a review.
6. Log in as `admin` and inspect all bookings.
