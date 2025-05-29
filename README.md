# Student Coaching System

This project is a web application developed to manage communication and coaching processes between students and coaches.

## Features

- Student and coach registration system
- Session management and secure authentication
- Email verification system
- Coaching session planning and tracking
- Progress reports and evaluations
- Messaging system

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite
- Web server (Apache/Nginx)

## Installation

1. Clone the project:
```bash
git clone https://github.com/username/student_coaching.git
cd student_coaching
```

2. Install Composer dependencies:
```bash
composer install
```

3. Set up environment variables:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database settings in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_coaching
DB_USERNAME=root
DB_PASSWORD=
```

5. Run database migrations:
```bash
php artisan migrate
```

6. Install frontend dependencies:
```bash
npm install
npm run dev
```

7. Start the application:
```bash
php artisan serve
```

The application will start running at http://localhost:8000

## Development

- Start the development server with `php artisan serve`
- Start the Vite development server with `npm run dev`

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Contact

Project Owner - [@Abdulkadir İpek](https://github.com/Abdulkadir-Ipek) - [@Muratcan Yazılı](https://github.com/Zpeairr)

