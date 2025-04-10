# Thanyaret - Internal Communication System 🚀

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-07405E?style=for-the-badge&logo=sqlite&logoColor=white)

An elegant internal communication system designed to help employees from different departments share ideas and exchange information through a public discussion board. The platform supports anonymous posting and various sorting options for discussions.

## ✨ Key Features

- 📝 Create new discussion topics to communicate with other employees
- 💬 Comment on existing topics with the option to remain anonymous
- 🔄 View topics sorted by latest or oldest
- 📊 Display topics with comment counts and most recent activity
- 📱 Fully responsive design for all screen sizes
- 🔐 User authentication system with registration and login
- 📋 Admin panel for managing users, topics, and comments
- 📊 Dashboard with analytics and system overview
- 📄 Comprehensive logging of all system events

## 🛠️ System Requirements

- PHP 8.2 or higher
- Composer
- SQLite or any database supported by Laravel
- Node.js and NPM (for frontend assets)

## 📦 Installation

1. Clone this repository to your machine:

```bash
git clone https://github.com/your-username/thanyaret-system.git
cd thanyaret-system
```

2. Install PHP dependencies with Composer:

```bash
composer install
```

3. Copy the .env.example file to .env:

```bash
cp .env.example .env
```

4. Generate application key:

```bash
php artisan key:generate
```

5. Set up SQLite database (or your preferred database):

For SQLite:
```bash
touch database/database.sqlite
```

And update your .env file:
```
DB_CONNECTION=sqlite
```

6. Run migrations to create database tables:

```bash
php artisan migrate
```

7. (Optional) Seed the database with sample data:

```bash
php artisan db:seed
```

8. Start the development server:

```bash
php artisan serve
```

Access the application at http://localhost:8000

## 🖥️ Application Structure

1. **Topics List** - Main page showing all discussion topics with filtering and sorting options
2. **Topic Form** - Page for creating new discussion topics
3. **Topic Details** - Page showing topic details and all comments with a form to add new comments
4. **User Authentication** - Registration and login pages
5. **Admin Area** - Administrative dashboard for system management

## 👤 Default Admin Account

After seeding the database, you can log in with these credentials:

- Email: admin@example.com
- Password: password

## 🧩 Interface Preview

The system features a clean, modern interface built with Tailwind CSS:

- **Navigation**: Easy access to all system features
- **Topics List**: Sortable and filterable view of all discussions
- **Topic Detail**: Rich content display with comment section
- **Comments**: Interactive commenting system with sorting options

## 🔍 Available Sorting Options

- **Latest** - Sort topics by most recent creation date
- **Oldest** - Sort topics by oldest creation date

## 🚀 Future Development

Planned features for future releases:

1. Email notifications for new comments
2. Topic categorization system
3. Advanced search functionality
4. User profile customization
5. Like/dislike system for comments
6. Rich text editor for content creation

## 📊 Performance and Optimization

The application has been optimized for:
- Fast page loading with minimal database queries
- Efficient data pagination
- Responsive design for all devices
- Lightweight assets for quick rendering

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-source, developed by Thanyaret.

---

Developed with ❤️ by Thanyaret Team
