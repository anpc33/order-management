# Order Management System

A modern, multilingual order management system built with Laravel 12, featuring a responsive dashboard, dark mode support, and comprehensive order tracking capabilities.

## Features

### Core Features
- **Multilingual Support**
  - English (en)
  - Vietnamese (vi)
  - Chinese (zh)
  - Easy language switching with session persistence

- **User Interface**
  - Responsive design for all devices
  - Dark/Light theme support
  - Modern and intuitive dashboard
  - Real-time statistics and charts

- **User Management**
  - Role-based access control (Admin/User)
  - User profile management
  - Avatar upload support
  - Customizable user preferences

- **Order Management**
  - Create and track orders
  - Order status updates
  - Order history
  - Export functionality

- **Product Management**
  - Product catalog
  - Stock tracking
  - Price management
  - Product categories

- **Customer Management**
  - Customer database
  - Order history per customer
  - Customer preferences

### Technical Features
- Laravel 12 framework
- Bootstrap 5 for responsive design
- Font Awesome icons
- Chart.js for data visualization
- Secure authentication system
- Database migrations and seeders
- RESTful API architecture

## Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM
- Laravel 12

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd order-management
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Create storage link:
```bash
php artisan storage:link
```

9. Start the development server:
```bash
php artisan serve
```

10. In a separate terminal, start Vite:
```bash
npm run dev
```

## Usage

1. Access the application at `http://localhost:8000`
2. Login with default credentials:
   - Email: admin@example.com
   - Password: password

3. Navigate through the dashboard to:
   - Manage orders
   - Update product inventory
   - Handle customer information
   - Configure user preferences

## Language Support

The system supports three languages:
- English (en)
- Vietnamese (vi)
- Chinese (zh)

To switch languages:
1. Click the language selector in the navigation bar
2. Select your preferred language
3. The interface will update immediately

## Theme Support

The system supports both light and dark themes:
1. Go to User Profile
2. Select your preferred theme
3. The interface will update automatically

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Security

If you discover any security-related issues, please email [your-email] instead of using the issue tracker.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

- Laravel Framework
- Bootstrap
- Font Awesome
- Chart.js
- All contributors who have helped shape this project
