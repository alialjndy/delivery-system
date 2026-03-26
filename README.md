# 🚚 Delivery System

A robust and scalable delivery management platform built with **Laravel 12**, following **Domain-Driven Design (DDD)** and **Event-Driven Architecture** principles.

---

## 📌 Overview

Delivery System is a full-featured logistics application that connects **Customers**, **Drivers**, and **Admins** through a unified platform. It supports real-time order tracking, multiple payment gateways, an in-app wallet, and automated driver location simulation — all powered by a modern, containerized stack.

---

## ✨ Features

- 👥 **Multi-Role System** — Customer, Driver, Admin with granular permissions via Spatie
- 📦 **Order Management** — Full order lifecycle from placement to delivery
- 💳 **Multiple Payment Gateways** — Stripe & PayPal integration
- 👛 **In-App Wallet** — Built for extensibility and future feature enrichment
- 📍 **Auto Driver Location** — Simulated coordinates injected via seeders/factories (kept clean with TTL-based Redis storage)
- 🔔 **Push Notifications** — Firebase FCM integration
- 🔐 **Authentication** — JWT-based auth with Laravel Sanctum & Socialite
- 🏗️ **DDD + Event-Driven Design** — Clean domain boundaries and decoupled event handling
- ⚡ **Redis** — Used for caching, queues, and ephemeral location data

---

## 🛠️ Tech Stack

| Layer             | Technology                                       |
| ----------------- | ------------------------------------------------ |
| Backend Framework | Laravel 12 (PHP 8.2+)                            |
| Architecture      | DDD + Event-Driven Design                        |
| Authentication    | JWT (`php-open-source-saver/jwt-auth`) + Sanctum |
| Authorization     | Spatie Laravel Permission                        |
| Payment           | Stripe, PayPal                                   |
| Notifications     | Firebase FCM (`kreait/laravel-firebase`)         |
| Social Login      | Laravel Socialite                                |
| Cache / Queue     | Redis                                            |
| Containerization  | Docker (Laravel Sail)                            |
| Database          | MySQL 8.4                                        |

---

## 📋 Requirements

- [Docker](https://www.docker.com/get-started) (v20+)
- [Docker Compose](https://docs.docker.com/compose/) (v2+)

> No need to install PHP, Composer, or any library locally — everything runs inside Docker.

---

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/delivery-system.git
cd delivery-system
```

### 2. Copy Environment File

```bash
cp .env.example .env
```

### 3. Start Docker Containers

```bash
docker compose up -d
```

### 4. Install Dependencies & Setup Application

```bash
# Install PHP dependencies
docker compose exec laravel.test composer install

# Generate app key
docker compose exec laravel.test php artisan key:generate

# Generate JWT secret
docker compose exec laravel.test php artisan jwt:secret

# Run database migrations
docker compose exec laravel.test php artisan migrate

# Seed the database
docker compose exec laravel.test php artisan db:seed
```

### 5. Start the Queue Worker

```bash
docker compose exec laravel.test php artisan queue:work redis
```

---

## 📚 API Documentation

Full API reference is available on Postman:

👉 **[View API Documentation](https://documenter.getpostman.com/view/37833857/2sBXiknWFS)**

---

## 💛 Wallet System

The `WalletContext` is designed with **extensibility in mind**. While currently supporting basic balance management, it is architected to support future features such as:

- Cashback & reward points
- Wallet-to-wallet transfers
- Promotional credits
- Auto top-up rules

---

## 📍 Driver Location Simulation

Driver coordinates are automatically injected via **factories/seeders** to simulate real-world scenarios during development and testing. Location data is stored in **Redis with a TTL**, ensuring the database is never polluted with stale coordinates.

---

## 🧰 Useful Commands

```bash
# View running containers
docker compose ps

# Stop all containers
docker compose down

# View application logs
docker compose logs -f laravel.test

# Run tests
docker compose exec laravel.test php artisan test

# Clear all caches
docker compose exec laravel.test php artisan optimize:clear

# Access MySQL shell
docker compose exec mysql mysql -u sail -p delivery_system

# Access Redis CLI
docker compose exec redis redis-cli
```

---

## 📦 Key Packages

| Package                             | Purpose                      |
| ----------------------------------- | ---------------------------- |
| `laravel/sanctum`                   | API token authentication     |
| `php-open-source-saver/jwt-auth`    | JWT authentication           |
| `spatie/laravel-permission`         | Role & permission management |
| `stripe/stripe-php`                 | Stripe payment gateway       |
| `kreait/laravel-firebase`           | Firebase integration         |
| `laravel-notification-channels/fcm` | Push notifications via FCM   |
| `laravel/socialite`                 | OAuth social login           |

---

<!-- ## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE). -->
