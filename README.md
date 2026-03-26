# Buyvia - E-Commerce Platform

A full-featured Laravel-based e-commerce platform with modern design, mobile responsiveness, and payment integration.

## Features

### Customer Features
- User registration and authentication
- Product browsing with search and filtering
- Shopping cart with coupon support
- Saved addresses for faster checkout
- Order tracking and history
- Wishlist functionality
- Product reviews and ratings

### Admin Features
- Dashboard with analytics
- Product management (CRUD)
- Category and brand management
- Order management
- Coupon system
- Hero slider management
- Hot deals management
- Customer management
- Review moderation
- Site settings

### Technical Features
- Mobile-responsive design
- Paystack payment integration
- AJAX cart operations
- Image storage in public folder
- Session-based cart
- Database caching

## Requirements

- PHP 8.2+
- Laravel 12.x
- MySQL 5.7+
- Node.js (for Tailwind CSS)

## Installation

1. **Clone and install dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your database and payment credentials
   ```

3. **Generate key and run migrations**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

4. **Build assets**
   ```bash
   npm run build
   ```

5. **Start server**
   ```bash
   php artisan serve
   ```

## Configuration

### Payment (Paystack)
Update these in `.env`:
```
PAYSTACK_PUBLIC_KEY=pk_live_xxx
PAYSTACK_SECRET_KEY=sk_live_xxx
```

### Shipping Rates
Configure in Admin Panel > Settings:
- Standard delivery cost
- Express delivery cost  
- Free shipping threshold

### Site Settings
Configure in Admin Panel > Settings:
- Site name and tagline
- Currency symbol
- Tax rate
- Default country
- Social media links

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin controllers
│   ├── CustomerController.php
│   ├── CheckoutController.php
│   ├── HomeController.php
│   └── ShopController.php
├── Models/            # Eloquent models
├── Services/         # Business logic
│   ├── CartService.php
│   ├── OrderService.php
│   └── PaystackService.php
resources/views/
├── admin/            # Admin panel views
├── pages/            # Public pages
├── layouts/          # Layout templates
└── partials/        # Reusable components
```

## Routes

| Route | Description |
|-------|-------------|
| `/` | Home page with hero slider, hot deals |
| `/shop` | Product listing |
| `/product/{slug}` | Product detail |
| `/cart` | Shopping cart |
| `/checkout` | Checkout page |
| `/account` | Customer dashboard |
| `/admin` | Admin panel |

## Development Notes

- Images stored in `public/images/`
- Avatar uploads go to `public/images/avatars/`
- Hero slider images go to `public/images/`
- Uses Tailwind CSS via CDN
- Uses Alpine.js for interactivity
- Mobile-first responsive design

## License

MIT License