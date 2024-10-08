## Reading Application Backend

## Overview
This project is the backend service for a Reading Application that allows users to browse, search, and manage their book library. The backend provides RESTful APIs to handle user authentication, book management, and reading progress tracking.

## Features
- User Authentication: Register, login, and manage user sessions.
- Book Management: Add, update, and delete books from the library.
- Reading Progress: Track the progress of books being read by users.
- Search & Browse: Search books by title, author, or genre.
- Technologies Used
- Framework: Laravel (PHP)
- Database: MySQL (or any relational DB)
- Authentication: JWT (JSON Web Token)

## Prerequisites
To run this project locally, you'll need the following installed:
- PHP 8.0+
- Composer
- MySQL

## Installation

1- Clone the repository:
``` bash
git clone https://github.com/username/reading-app-backend.git
cd reading-app-backend
```

2- Install dependencies: Use Composer to install the necessary dependencies:
```
composer install
```

3- Run database migrations:
```
php artisan migrate
```

4- Seed the database (optional): If you have seeders available to populate the database with initial data, run:
```
php artisan db:seed
```

5- Start the development server:
```
php artisan serve
```

The application will now be running at http://localhost:8000.

## License
This project is licensed under the MIT License.
