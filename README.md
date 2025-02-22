<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# SwiftCart E-commerce Platform

## Overview

SwiftCart is a modern, feature-rich e-commerce platform built with Laravel. It provides a seamless shopping experience for customers and powerful management tools for store owners.

## Key Features

- Responsive product catalog with detailed product pages
- User-friendly shopping cart and checkout process
- Customer reviews and ratings system
- Related products suggestions
- Wishlist functionality
- Discount and sale price management
- Admin dashboard for product and order management

## Technologies Used

- Laravel
- PHP
- MySQL
- Blade templating engine
- Bootstrap
- Tailwind CSS

## Getting Started

### Prerequisites

- PHP 8.0+
- Composer
- Node.js and npm
- MySQL

### Installation

1. Clone the repository:
   https://github.com/zerakjamil/SwiftCart-E-Commerce.git
   
3. Navigate to the project directory:
   ```
   cd ecommerce
   ```
   
5. Install PHP dependencies
   ```
   composer install
   ```
   
4.Install JavaScript dependencies:
```
  npm install
```

5.  Copy the `.env.example` file to `.env` and configure your database settings.

6. Generate an application key:
   ```
   php artisan key:generate
   ```

8. Run database migrations:
   ```
   php artisan migrate
   ```

9. Seed the database (optional)
   ```
   php artisan db:seed
   ```
   
10. Start the development server:
 ```
 php artisan serve
 ```

Visit `http://localhost:8000` in your browser to see the application.

## Usage

- Browse the product catalog
- Add items to your cart
- Manage your wishlist
- Leave product reviews
- Complete the checkout process

For admin access, visit `/admin` and log in with your admin credentials.
For admin login, visit `/admin/login` the credentials will be `admin@tst.com` - `123` if you have seeded the database
## Project Structure

- `app/`: Contains the core logic of the application
- `bootstrap/`: Laravel's bootstrapping files
- `config/`: Configuration files
- `database/`: Database migrations and seeders
- `public/`: Publicly accessible files
- `resources/`: Views, raw assets (SASS, JS, etc)
- `routes/`: Application routes
- `storage/`: Application storage
- `tests/`: Application tests

### Running Tests
php artisan test

## Contributing

I welcome contributions to SwiftCart! Please read SwiftCart's [Contributing Guide](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Laravel community
- Bootstrap and Tailwind CSS teams
- All open-source packages used in this project

## Learning Laravel

Laravel has extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.
