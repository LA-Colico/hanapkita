# Hanapkita - Job Portal System

A comprehensive PHP-based job portal system that connects job seekers with employers.

## Features

### For Job Seekers
- User registration and profile management
- Resume upload and management
- Job search and filtering
- Apply for jobs
- Track application status
- Education and experience management

### For Employers
- Company registration
- Post job listings
- View and manage candidates
- Search for candidates
- Track applications
- Hire or reject candidates

### Admin Panel
- Manage job categories
- View registered employers and job seekers
- Monitor job listings
- Generate reports
- Activity logs
- Search functionality

## Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache/Nginx web server
- Web browser (Chrome, Firefox, Safari, Edge)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/hanapkita.git
cd hanapkita
```

### 2. Database Setup

1. Create a MySQL database named `hanapkita`
2. Import the database file:
   ```bash
   mysql -u root -p hanapkita < hanapkita.sql
   ```

### 3. Configure Database Connection

Update the database credentials in the following files:

**hanapkita/includes/config.php:**
```php
define('DB_HOST','localhost');
define('DB_USER','your_username');
define('DB_PASS','your_password');
define('DB_NAME','hanapkita');
```

**hanapkita/admin/includes/dbconnection.php:**
```php
define('DB_HOST','localhost');
define('DB_USER','your_username');
define('DB_PASS','your_password');
define('DB_NAME','hanapkita');
```

**hanapkita/employers/includes/config.php:**
```php
define('DB_HOST','localhost');
define('DB_USER','your_username');
define('DB_PASS','your_password');
define('DB_NAME','hanapkita');
```

### 4. Deploy to Web Server

- Copy the `hanapkita` folder to your web server's document root (e.g., `htdocs`, `www`, `public_html`)
- Ensure proper file permissions are set

### 5. Access the Application

- **Frontend:** http://localhost/hanapkita/
- **Admin Panel:** http://localhost/hanapkita/admin/
- **Employer Panel:** http://localhost/hanapkita/employers/

## Default Admin Credentials

(Check your database after import for default admin credentials)

## Project Structure

```
Hanapkita/
├── hanapkita/              # Main application folder
│   ├── admin/              # Admin panel
│   ├── employers/          # Employer portal
│   ├── includes/           # Configuration and common files
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript files
│   ├── images/             # Image assets
│   ├── fonts/              # Font files
│   ├── Jobseekersresumes/  # Resume uploads
│   └── *.php               # Frontend pages
├── hanapkita.sql           # Database file
└── README.md               # This file
```

## Key Pages

- `index.php` - Homepage
- `sign-up.php` - Job seeker registration
- `sign-in.php` - Job seeker login
- `job-search.php` - Search for jobs
- `profile.php` - User profile
- `employers-signup.php` - Employer registration

## Security Note

**IMPORTANT:** Before deploying to production:
- Change all default passwords
- Update database credentials
- Enable HTTPS
- Set appropriate file permissions
- Keep PHP and database software updated

## Technologies Used

- PHP
- MySQL
- HTML/CSS
- JavaScript
- Bootstrap
- jQuery

## License

This project is open source and available for educational purposes.

## Support

For issues and questions, please open an issue in the GitHub repository.
