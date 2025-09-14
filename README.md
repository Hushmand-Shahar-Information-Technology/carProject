# Car Dealer 
A professional, modern, and highly customizable Laravel Project for car dealerships websites.

## Features
- **Cars Management**: Manage your car inventory with ease. Add, edit, and delete cars, and assign them to categories and tags.
- **Categories Management**: Create and manage categories for your cars.
- **Tags Management**: Create and manage tags for your cars.
- **Search and Filter**: Allow users to search and filter cars by make, model, year, price, and more.
- **Car Details Page**: Display detailed information about each car, including photos, features, and pricing.
- **Auction System**: Allow users to create auctions for cars with automatic expiration handling.
- **Contact Form**: Allow users to contact you with questions or to schedule a test drive.
- **Responsive Design**: The package includes a responsive design, making it easy to view on any device.

## Requirements
- **Laravel 8.x**: This package is built for Laravel 8.x.
- **PHP 7.3.x**: This package requires PHP 7.3.x or higher.
- **composer**: This package requires composer to install.
- **npm or yarn**: This package requires npm or yarn to install dependencies.

## Installation
1. Install the package via composer:

## Auction System Setup
To enable automatic expiration of auctions, you need to set up the Laravel task scheduler:

### Option 1: Using Cron Job (Recommended for Production)
Add this cron entry to your server:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Option 2: Manual Testing (Development)
You can manually run the auction expiration command:
```bash
php artisan auctions:end-expired
```

### Option 3: Running Scheduler in Development
For development, you can run the scheduler continuously:
```bash
php artisan schedule:work
```

The system will automatically check every minute for expired auctions and update their status to 'ended'.

