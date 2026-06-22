# BookTix - Event Booking Platform Analysis

**Analyzed:** June 22, 2026  
**Version:** Laravel 12  
**Repository:** C:\LaravelProjek\event-booking

---

## ðŸ“‹ Executive Summary

BookTix is a modern event ticket booking platform built with Laravel 12 that enables users to discover, book, and purchase event tickets with integrated Midtrans payment processing. The system features a dual-interface architecture with separate user and admin portals, real-time quota management, and automated ticket generation via payment webhooks.

---

## ðŸ›  Tech Stack

### Backend
- **Framework:** Laravel 12.0
- **PHP Version:** 8.2+
- **Database:** MySQL 8.0
- **Authentication:** Laravel Breeze (with email verification)
- **Payment Gateway:** Midtrans Snap API
- **Testing:** PestPHP 3.8

### Frontend
- **Template Engine:** Blade
- **CSS Framework:** Tailwind CSS 3.1
- **JavaScript:** Alpine.js 3.4
- **Build Tool:** Vite 7.0
- **Forms:** @tailwindcss/forms

### Additional Libraries
- **QR Code:** simplesoftwareio/simple-qrcode (installed, not implemented)
- **Concurrency:** concurrently (for dev environment)
- **HTTP Client:** Axios 1.11

---

## ðŸ— Architecture Overview

### System Type
Monolithic MVC architecture with server-side rendering (Blade templates)

### Key Architectural Patterns
- **Repository Pattern:** Not implemented (uses Eloquent directly)
- **Service Layer:** Not implemented (business logic in controllers)
- **Event-Driven:** Partial (Midtrans webhooks)
- **Queue Processing:** Configured (composer dev runs queue:listen)

### Authentication Architecture
- **Dual Guard System:**
  - `web` guard: Regular users
  - `admin` guard: Admin users
- **Middleware:** RoleMiddleware checks user role + guard
- **Email Verification:** Required for user actions (verified middleware)

---

## ðŸ—„ Database Schema

### Tables Overview

#### 1. **users**
```
id (PK)
name
email (unique)
email_verified_at
password
role (enum: 'user', 'admin')
remember_token
timestamps
```

#### 2. **events**
```
id (PK)
title
slug (unique, auto-generated)
image (nullable, stored in storage/app/public/events/)
description (text)
location
event_date (datetime)
price (integer)
quota (integer)
available_quota (integer)
created_by (FK â†’ users.id)
timestamps
```

#### 3. **orders**
```
id (PK)
user_id (FK â†’ users.id)
order_code (unique, format: BTX-{RANDOM10})
total_price (integer)
status (enum: 'pending', 'paid', 'cancelled')
timestamps
```

#### 4. **order_items**
```
id (PK)
order_id (FK â†’ orders.id)
event_id (FK â†’ events.id)
quantity (integer, max: 10)
subtotal (integer)
timestamps
```

#### 5. **payments**
```
id (PK)
order_id (FK â†’ orders.id)
transaction_id (Midtrans transaction ID)
payment_type (e.g., 'bank_transfer', 'gopay', 'credit_card')
transaction_status (e.g., 'pending', 'settlement', 'capture')
raw_response (json, full Midtrans webhook payload)
timestamps
```

#### 6. **tickets**
```
id (PK)
order_id (FK â†’ orders.id)
event_id (FK â†’ events.id)
user_id (FK â†’ users.id)
ticket_code (unique, format: BTX-{EVENT_ID}-{RANDOM8})
status (enum: 'unused', default)
timestamps
```

### Additional Tables (Laravel Default)
- **cache**, **cache_locks**: Caching system
- **jobs**, **job_batches**, **failed_jobs**: Queue system
- **password_reset_tokens**: Password recovery
- **sessions**: Session storage

---

## ðŸ”— Models & Relationships

### User Model
```php
hasMany(Order)
role: 'user' | 'admin'
```

### Event Model
```php
hasMany(OrderItem)
hasMany(Ticket)
belongsTo(User, 'created_by')

Auto-generates slug on create/update: {slug}-{uniqid}
```

### Order Model
```php
belongsTo(User)
hasMany(OrderItem, 'items')
hasOne(Payment)
hasMany(Ticket)
```

### OrderItem Model
```php
belongsTo(Order)
belongsTo(Event)
```

### Payment Model
```php
belongsTo(Order)
```

### Ticket Model
```php
belongsTo(Order)
belongsTo(Event)
belongsTo(User) - indirect via order
```

---

## âœ¨ Key Features

### User Features
1. **Authentication**
   - Registration with email verification (Laravel Breeze)
   - Login/logout
   - Password reset
   - Profile management

2. **Event Discovery**
   - Homepage with upcoming events
   - Event listing page with pagination (9 per page)
   - Search by title or location
   - Filter by availability (available/full)
   - Event detail page with full information

3. **Ticket Booking**
   - Select quantity (1-10 tickets per order)
   - Real-time quota validation
   - Instant quota reservation (optimistic locking)
   - Automatic order code generation

4. **Payment Processing**
   - Midtrans Snap popup integration
   - Multiple payment methods:
     - Credit Card (Visa, Mastercard)
     - Bank Transfer (BCA, Mandiri, BNI, etc.)
     - E-wallet (GoPay, ShopeePay, etc.)
   - Sandbox mode for testing

5. **Order Management**
   - Order history with status tracking
   - Order detail view with payment button
   - Digital tickets after payment confirmation

### Admin Features
1. **Separate Admin Portal**
   - Independent login system (/admin/login)
   - Role-based access control
   - Dedicated admin guard

2. **Event Management**
   - Create new events with image upload
   - Edit event details
   - Update quota (auto-adjusts available_quota)
   - Delete events
   - Slug-based routing for SEO

3. **Order Monitoring**
   - View all orders across all users
   - Order detail with user information
   - Manual status updates
   - Payment tracking

4. **Dashboard**
   - Latest events listing
   - Paginated view (20 per page)

---

## ðŸ”„ Business Logic Flow

### 1. Booking Flow
```
User selects event + quantity
    â†“
EventController@book validates:
  - Event exists
  - Quantity (1-10)
  - Available quota >= quantity
    â†“
DB Transaction:
  - Decrement event.available_quota
  - Create Order (status: 'pending')
  - Create OrderItem
    â†“
Redirect to Order Detail page
```

**Key Implementation (EventController.php:69-105):**
- Uses DB transaction for atomicity
- Optimistic quota reservation (decremented immediately)
- Order code: `BTX-{RANDOM10}`
- Total price calculated: `event.price Ã— quantity`

### 2. Payment Flow
```
Order Detail page loads
    â†“
Frontend requests snap_token
    â†“
PaymentController@snapToken:
  - Validates order ownership
  - Validates status = 'pending'
  - Generates Midtrans Snap token
  - Order ID format: {order_code}-{timestamp}
    â†“
User completes payment in Midtrans popup
    â†“
Midtrans sends webhook to /webhook/midtrans
    â†“
MidtransWebhookController@handle:
  1. Validate signature (SHA512)
  2. Find order by order_code
  3. Determine status from transaction_status
  4. DB Transaction:
     - Update/create Payment record
     - Update Order status
     - Generate tickets if status = 'paid'
     - Restore quota if status = 'cancelled'
    â†“
User sees updated order status + tickets
```

**Webhook Signature Validation (MidtransWebhookController.php:24-39):**
```php
SHA512(order_id + status_code + gross_amount + server_key)
```

**Status Mapping (MidtransWebhookController.php:108-127):**
- `settlement` â†’ `paid`
- `capture` + `fraud_status: accept` â†’ `paid`
- `pending` â†’ `pending`
- `cancel`, `expire`, `deny` â†’ `cancelled`

### 3. Ticket Generation Flow
```
Order status changes to 'paid'
    â†“
Check: order.tickets.count() === 0
    â†“
For each OrderItem:
  For i = 1 to quantity:
    Create Ticket:
      - ticket_code: BTX-{EVENT_ID}-{RANDOM8}
      - status: 'unused'
      - Unique validation
```

**Implementation (MidtransWebhookController.php:150-163):**
- Generates multiple tickets if quantity > 1
- Unique code with retry logic
- Prevents duplicate generation with count check


### 4. Quota Management Flow

**Reservation (Immediate):**
- Decremented when order created
- Ensures inventory consistency
- Prevents overselling

**Restoration (on Cancel/Expire):**
`
MidtransWebhookController@restoreQuota:
  - Checks previous status !== 'cancelled'
  - Prevents double restoration
  - Increments available_quota by order quantity
`

---

## ?? Controllers Detail

### User-Facing Controllers

#### **EventController** (app/Http/Controllers/EventController.php)
**Purpose:** Main user interface for browsing and booking events

**Methods:**
- `home()`: Homepage with 6 upcoming events + stats
- `index(Request)`: Event listing with search/filter (9 per page)
- `show(Event)`: Event detail page (route model binding with slug)
- `book(Request)`: Process booking, create order + order item

**Key Logic:**
- Search by title OR location (LIKE query)
- Filter by availability (available_quota > 0)
- Quota validation before booking
- DB transaction for order creation

#### **PaymentController** (app/Http/Controllers/PaymentController.php)
**Purpose:** Generate Midtrans Snap tokens for payment

**Methods:**
- `snapToken(Order)`: Generate payment token

**Security Checks:**
- Order ownership validation (user_id === auth()->id())
- Order status must be 'pending'

**Midtrans Configuration:**
- Server key from config
- Sandbox/production mode toggle
- 3DS enabled for card security
- Sanitization enabled

**Transaction Details:**
- order_id: `{order_code}-{timestamp}` (ensures uniqueness)
- gross_amount: total_price as integer
- customer_details: name + email
- item_details: array of events with price/quantity

#### **UserOrderController** (app/Http/Controllers/UserOrderController.php)
**Purpose:** User's order history and details

**Methods:**
- `index()`: List user's orders (filtered by auth()->id())
- `show(Order)`: Order detail with items, payment, tickets

**Features:**
- Order code-based routing (route model binding)
- Ownership validation implicit (user_id filter)

#### **MidtransWebhookController** (app/Http/Controllers/MidtransWebhookController.php)
**Purpose:** Handle payment notifications from Midtrans

**Critical Methods:**
- `handle(Request)`: Main webhook handler
- `resolveOrderStatus()`: Map Midtrans status to order status
- `resolvePaymentStatus()`: Map Midtrans status to payment status
- `generateTickets()`: Create ticket records
- `restoreQuota()`: Return quota on cancellation
- `generateUniqueCode()`: Create unique ticket codes

**Security:**
- SHA512 signature validation
- Server key verification
- 403 response on invalid signature

**Idempotency:**
- Checks if order already in target status
- Prevents duplicate ticket generation (count check)
- Prevents double quota restoration (previous status check)

**Order Matching:**
- Primary: exact order_code match
- Fallback: LIKE pattern for timestamp suffix

### Admin Controllers

#### **Admin\AuthController** (app/Http/Controllers/Admin/AuthController.php)
**Purpose:** Admin authentication (separate from user auth)

**Methods:**
- `showLogin()`: Admin login form
- `login(Request)`: Process admin login
- `logout()`: Admin logout

**Guard:** Uses 'admin' guard (likely custom implementation)

#### **Admin\EventController** (app/Http/Controllers/Admin/EventController.php)
**Purpose:** Admin event CRUD operations

**Methods:**
- `index()`: List all events (10 per page, latest first)
- `create()`: Show event creation form
- `store(Request)`: Create new event
- `edit(Event)`: Show event edit form
- `update(Request, Event)`: Update existing event
- `destroy(Event)`: Delete event

**Key Features:**
- Image upload to `storage/app/public/events/`
- Image deletion on update/remove
- Slug auto-generation on create/update
- Quota adjustment logic:
  - If quota increased ? increase available_quota by difference
  - Prevents negative available_quota

**Validation:**
- title, description, location: required
- event_date: required|date
- price, quota: required|integer
- image: optional file upload

#### **Admin\OrderController** (app/Http/Controllers/Admin/OrderController.php)
**Purpose:** Admin order management

**Methods:**
- `index()`: List all orders (all users)
- `show(Order)`: Order detail with user info
- `updateStatus(Request, Order)`: Manual status update

**Features:**
- Order code-based routing
- Cross-user visibility (admin sees all orders)

---

## ?? Routes Structure

### Public Routes (No Auth Required)
`php
GET  /                           ? EventController@home
GET  /events                     ? EventController@index
GET  /events/{event:slug}        ? EventController@show
`

### Authenticated User Routes
**Middleware:** `['auth', 'verified']`

`php
GET    /profile                  ? ProfileController@edit
PATCH  /profile                  ? ProfileController@update
DELETE /profile                  ? ProfileController@destroy

POST   /orders                   ? EventController@book
GET    /orders                   ? UserOrderController@index
GET    /orders/{order:order_code} ? UserOrderController@show
GET    /orders/{order}/snap-token ? PaymentController@snapToken
`

### Admin Routes
**Middleware:** `['auth:admin', 'role:admin']`  
**Prefix:** `/admin`

`php
GET  /admin/login                ? Admin\AuthController@showLogin
POST /admin/login                ? Admin\AuthController@login
POST /admin/logout               ? Admin\AuthController@logout

GET  /admin                      ? Redirect to dashboard or login
GET  /admin/dashboard            ? Closure (event list view)

Resource routes (slug-based):
GET    /admin/events             ? index
GET    /admin/events/create      ? create
POST   /admin/events             ? store
GET    /admin/events/{event:slug}/edit ? edit
PATCH  /admin/events/{event:slug} ? update
DELETE /admin/events/{event:slug} ? destroy

GET   /admin/orders              ? index
GET   /admin/orders/{order:order_code} ? show
PATCH /admin/orders/{order}/status ? updateStatus
`

### Webhook Routes (No CSRF)
`php
POST /webhook/midtrans           ? MidtransWebhookController@handle
`

### Auth Routes (Laravel Breeze)
Defined in `routes/auth.php`:
- Registration
- Login/logout
- Password reset
- Email verification

---

## ?? Security Features

### 1. Authentication & Authorization
- **Laravel Breeze:** Standard auth scaffolding
- **Email Verification:** Required for booking actions (`verified` middleware)
- **Dual Guard System:** Separate admin/user authentication
- **Role Middleware:** Validates user role + guard combination

### 2. Payment Security
- **Midtrans Signature Validation:** SHA512 hash verification
- **Server Key Protection:** Stored in .env, never exposed to frontend
- **3DS Enabled:** Card payment security
- **Webhook IP Whitelisting:** Not implemented (recommended addition)

### 3. Access Control
- **Order Ownership:** Users can only access their own orders
- **Admin Isolation:** Admin routes require admin role + admin guard
- **Route Model Binding:** Prevents manual ID manipulation

### 4. Data Integrity
- **DB Transactions:** Used for critical operations (booking, payment updates)
- **Quota Validation:** Checked before order creation
- **Unique Code Generation:** Retry logic for ticket/order codes
- **Foreign Key Constraints:** Enforced at database level

### 5. Input Validation
- **Form Requests:** Validation rules in controllers
- **CSRF Protection:** Laravel default (enabled for all POST/PATCH/DELETE)
- **SQL Injection Prevention:** Eloquent parameterized queries

### 6. File Upload Security
- **Storage Location:** `storage/app/public` (not web-accessible directly)
- **File Deletion:** Old images deleted on update
- **Public Access:** Via symbolic link `php artisan storage:link`

---

## ?? Code Conventions & Naming

### Naming Patterns
- **Order Code:** `BTX-{10 CHAR RANDOM UPPERCASE}`
- **Ticket Code:** `BTX-{EVENT_ID}-{8 CHAR RANDOM UPPERCASE}`
- **Event Slug:** `{slug}-{uniqid()}`
- **Midtrans Order ID:** `{order_code}-{unix_timestamp}`

### Database Conventions
- **Table Names:** Plural, snake_case (`order_items`, `events`)
- **Foreign Keys:** `{model}_id` (`user_id`, `event_id`)
- **Timestamps:** Laravel default (`created_at`, `updated_at`)
- **Status Fields:** String enums (not database enums)

### Code Style
- **Namespaces:** PSR-4 autoloading
- **Controllers:** Suffix with `Controller`
- **Models:** Singular, PascalCase
- **Methods:** camelCase
- **Routes:** Kebab-case URLs

---

## ?? Project Structure

\\\
event-booking/
+-- app/
¦   +-- Http/
¦   ¦   +-- Controllers/
¦   ¦   ¦   +-- Admin/
¦   ¦   ¦   ¦   +-- AuthController.php
¦   ¦   ¦   ¦   +-- EventController.php
¦   ¦   ¦   ¦   +-- OrderController.php
¦   ¦   ¦   +-- Auth/ (Breeze)
¦   ¦   ¦   +-- Controller.php
¦   ¦   ¦   +-- EventController.php
¦   ¦   ¦   +-- MidtransWebhookController.php
¦   ¦   ¦   +-- PaymentController.php
¦   ¦   ¦   +-- ProfileController.php
¦   ¦   ¦   +-- UserOrderController.php
¦   ¦   +-- Middleware/
¦   ¦   ¦   +-- RoleMiddleware.php
¦   ¦   +-- Requests/
¦   +-- Models/
¦   ¦   +-- Event.php
¦   ¦   +-- Order.php
¦   ¦   +-- OrderItem.php
¦   ¦   +-- Payment.php
¦   ¦   +-- Ticket.php
¦   ¦   +-- User.php
¦   +-- Providers/
+-- config/
¦   +-- midtrans.php
+-- database/
¦   +-- factories/
¦   +-- migrations/ (11 files)
¦   +-- seeders/
¦       +-- DatabaseSeeder.php
+-- resources/
¦   +-- views/
¦       +-- admin/
¦       +-- auth/
¦       +-- components/
¦       +-- events/
¦       +-- layouts/
¦       +-- orders/
¦       +-- profile/
¦       +-- welcome.blade.php
+-- routes/
¦   +-- auth.php
¦   +-- console.php
¦   +-- web.php
+-- storage/
    +-- app/
        +-- public/
            +-- events/ (uploaded images)
\\\

---

## ?? Configuration

### Environment Variables Required

\\\env
# Database
DB_DATABASE=event_booking_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Midtrans Payment Gateway
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# Email (Mailtrap for dev)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS=noreply@booktix.com
MAIL_FROM_NAME=BookTix
\\\

### Midtrans Config (config/midtrans.php)
\\\php
return [
    'server_key'    => env('MIDTRANS_SERVER_KEY'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized'  => true,
    'is_3ds'        => true,
];
\\\

---

## ?? Development Setup & Commands

### Installation
\\\ash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm run build
\\\

### Composer Scripts
\\\ash
composer setup    # Full installation (install + migrate + build)
composer dev      # Run server + queue + vite concurrently
composer test     # Run PestPHP tests
\\\

### Development Server (composer dev)
Runs 3 processes concurrently:
1. `php artisan serve` (port 8000)
2. `php artisan queue:listen --tries=1`
3. `npm run dev` (Vite HMR)

### Artisan Commands
\\\ash
php artisan serve              # Development server
php artisan migrate            # Run migrations
php artisan db:seed            # Run seeders
php artisan storage:link       # Link storage to public
php artisan queue:listen       # Process queued jobs
php artisan config:clear       # Clear config cache
php artisan test               # Run tests
\\\

---

## ?? Testing Credentials

### Default Admin (from README)
\\\
Email:    admin@mail.com
Password: password
URL:      http://127.0.0.1:8000/admin/login
\\\

**Note:** Admin seeder not implemented in DatabaseSeeder.php (needs manual creation)

### Test User (from seeder)
\\\
Email:    test@example.com
Password: password
\\\

### Midtrans Sandbox Testing

**Credit Card:**
\\\
Card Number: 4811 1111 1111 1114
Expiry:      01/39
CVV:         123
OTP:         112233
\\\

**BCA Virtual Account:**
- Any amount ? auto-approved in sandbox

**GoPay:**
- Use simulator: https://simulator.sandbox.midtrans.com

---

## ?? Notable Implementation Details

### 1. Optimistic Quota Reservation
- Quota decremented immediately on booking
- Prevents race conditions in high-traffic scenarios
- Restored only if order cancelled/expired

### 2. Webhook Idempotency
- Checks if order already in target status
- Prevents duplicate ticket generation
- Prevents double quota restoration
- Safe for webhook retries

### 3. Order ID Strategy
- Internal: `BTX-{RANDOM10}`
- Midtrans: `BTX-{RANDOM10}-{TIMESTAMP}`
- Webhook matches with LIKE pattern for flexibility

### 4. Slug Auto-Generation
- Uses Str::slug() + uniqid()
- Ensures uniqueness without database check
- Auto-regenerates on title change

### 5. Image Management
- Stored in `storage/app/public/events/`
- Old images deleted on update/remove
- Requires `php artisan storage:link` for public access

### 6. Transaction Safety
- DB transactions for booking
- DB transactions for webhook processing
- Prevents partial updates on failure

### 7. Route Model Binding
- Events use slug: `events/{event:slug}`
- Orders use order_code: `orders/{order:order_code}`
- Admin events also use slug
- Improves SEO and security

---

## ?? Potential Issues & Improvements

### Missing Implementations
1. **Admin Seeder:** README mentions admin@mail.com but not in DatabaseSeeder
2. **QR Code Generation:** Library installed but not implemented in views
3. **Email Notifications:** No order confirmation/status update emails
4. **Ticket Validation:** No scanning/validation system for tickets
5. **Event Categories:** No category/tag system for events
6. **Refund Handling:** No refund process for cancelled orders

### Security Recommendations
1. **Webhook IP Whitelisting:** Validate Midtrans IPs
2. **Rate Limiting:** Add throttle middleware to booking endpoint
3. **Admin 2FA:** Implement two-factor authentication for admin
4. **Order Expiry:** Automated expiry for pending orders (Midtrans handles this)
5. **File Upload Validation:** Add file type/size validation

### Performance Optimizations
1. **Eager Loading:** Add with() to prevent N+1 queries
2. **Database Indexing:** Index slug, order_code, ticket_code
3. **Caching:** Cache event listings for homepage
4. **Queue Jobs:** Move ticket generation to queue
5. **CDN:** Use CDN for event images

### User Experience Enhancements
1. **Order Timer:** Show countdown for payment deadline
2. **Email Notifications:** Order confirmation, payment success
3. **Ticket QR Codes:** Generate QR codes for tickets
4. **Event Search:** Full-text search with Elasticsearch
5. **Social Login:** Add Google/Facebook OAuth
6. **Multi-language:** i18n support

### Code Quality
1. **Service Layer:** Extract business logic from controllers
2. **Form Requests:** Use dedicated Request classes for validation
3. **Policies:** Implement authorization policies
4. **Unit Tests:** Add tests for critical business logic
5. **API Documentation:** Document webhook endpoint

---

## ?? Conclusion

BookTix is a well-structured event booking platform with solid foundational features. The system demonstrates good practices in:
- Payment gateway integration with webhook handling
- Transaction safety for critical operations
- Dual authentication system for user/admin separation
- RESTful routing with route model binding

The codebase follows Laravel conventions and uses framework features effectively. While there are opportunities for enhancement (email notifications, QR codes, service layer), the core booking and payment functionality is production-ready.

**Strengths:**
- Clean MVC architecture
- Robust payment webhook handling
- Transaction safety for booking flow
- Good separation of user/admin concerns

**Next Steps for Production:**
- Implement admin seeder
- Add email notifications
- Enable QR code generation
- Add comprehensive tests
- Implement webhook IP whitelisting
- Setup monitoring and logging

---

**Analysis Complete**  
**Total Files Analyzed:** 25+ controllers, models, migrations, routes  
**Lines of Code Reviewed:** ~2,000+ lines  
**Documentation Generated:** 2026-06-22 12:41:18
