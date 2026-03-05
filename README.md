# 🎟️ BookTix

> A modern event ticket booking platform built with Laravel 12.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Midtrans](https://img.shields.io/badge/Payment-Midtrans-003CA6?style=flat)

---

## ✨ Features

### User
- 🔐 Register & login with email verification
- 🎪 Browse and search events
- 🛒 Book event tickets
- 💳 Payment via Midtrans Snap (BCA VA, GoPay, Credit Card, etc.)
- 📋 Order history & ticket management
- 🎫 Digital ticket after payment confirmed

### Admin Panel
- 📅 Create, edit, delete events
- 📊 Manage orders & update status
- 🎟️ Monitor ticket quota
- 💰 Payment tracking via Midtrans webhook

---

## 🛠️ Tech Stack

- **Backend** — Laravel 12, PHP 8.2
- **Frontend** — Blade, Tailwind CSS, Vite
- **Database** — MySQL
- **Payment** — Midtrans Snap
- **Email** — SMTP (Mailtrap for development)
- **Auth** — Laravel Breeze with email verification

---

## 🚀 Installation

### Requirements
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/fadliilysn/BookTix.git
cd BookTix
```

**2. Install dependencies**
```bash
composer install
npm install
```

**3. Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure `.env`**
```env
DB_DATABASE=event_booking_db
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS="noreply@booktix.com"
MAIL_FROM_NAME="BookTix"
```

**5. Run migrations & seeders**
```bash
php artisan migrate
php artisan db:seed
```

**6. Build assets**
```bash
npm run dev
```

**7. Start the server**
```bash
php artisan serve
```

Visit `http://127.0.0.1:8000`

---

## 👤 Default Admin Account

After seeding, use this account to access the admin panel at `/admin/login`:

```
Email    : admin@mail.com
Password : password
```

---

## 💳 Payment Testing (Sandbox)

| Method | Details |
|--------|---------|
| Credit Card | `4811 1111 1111 1114` · exp: `01/39` · CVV: `123` · OTP: `112233` |
| BCA Virtual Account | Any amount, auto-approved |
| GoPay | Simulator at https://simulator.sandbox.midtrans.com |

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   ├── Auth/           # Authentication controllers
│   │   ├── EventController.php
│   │   ├── UserOrderController.php
│   │   ├── PaymentController.php
│   │   └── MidtransWebhookController.php
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── User.php
│   ├── Event.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Payment.php
│   └── Ticket.php
resources/
├── views/
│   ├── admin/              # Admin panel views
│   ├── auth/               # Login, register, verify email
│   ├── events/             # Event listing & detail
│   ├── orders/             # Order history & detail
│   └── layouts/            # User & admin layouts
```

---

## 🔐 Roles

| Role | Access |
|------|--------|
| `admin` | Admin panel (`/admin/*`) — manage events, orders |
| `user` | User frontend — browse events, book tickets |

---

## 📸 Screenshots

> Coming soon

---

## 📄 License

This project is open-sourced for educational purposes.

---

<p align="center">Built with ❤️ using Laravel</p>
