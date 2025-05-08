# Event-Management-3

## Download Instructions | تعليمات التنزيل

**English:**
1. Go to the project repository: https://github.com/omar-alselek/Event-Management-3
2. Click the green "Code" button.
3. Choose "Download ZIP" to download the project as a ZIP file, or copy the URL to clone with Git:
   ```
   git clone https://github.com/omar-alselek/Event-Management-3.git
   ```
4. Extract the ZIP file (if downloaded as ZIP) and open the folder in your code editor.

**العربية:**
1. انتقل إلى مستودع المشروع: https://github.com/omar-alselek/Event-Management-3
2. اضغط على زر "Code" الأخضر.
3. اختر "Download ZIP" لتنزيل المشروع كملف مضغوط، أو انسخ الرابط للنسخ باستخدام Git:
   ```
   git clone https://github.com/omar-alselek/Event-Management-3.git
   ```
4. فك ضغط الملف إذا قمت بتنزيله كملف ZIP وافتح المجلد في محرر الشيفرة الخاص بك.

A comprehensive Event Management System built with Laravel. This project allows admins, organizers, and attendees to manage events, tickets, bookings, and reports through a modern web interface and RESTful API.

## Features
- Admin, Organizer, and Attendee roles
- Event creation, editing, publishing, and management
- Ticket management (types, quantities, prices, activation)
- Booking system with QR code generation
- User management (ban, edit, delete)
- Event reporting and moderation
- API endpoints for mobile or external integration
- Modern Bootstrap-styled admin panel

## Requirements
- PHP >= 8.1
- Composer
- MySQL or compatible database
- Node.js & npm (for frontend assets)
- Git
- [Optional] XAMPP, WAMP, or Laravel Valet for local development

## Installation

### 1. Clone the Repository
```
git clone https://github.com/omar-alselek/Event-Management-3.git
cd Event-Management-3
```

### 2. Install PHP Dependencies
```
composer install
```

### 3. Install Node.js Dependencies
```
npm install
```

### 4. Copy and Configure Environment File
```
cp .env.example .env
```
Edit `.env` and set your database credentials and other environment variables as needed:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 5. Generate Application Key
```
php artisan key:generate
```

### 6. Run Database Migrations
```
php artisan migrate
```
If you encounter migration errors, run specific migrations as needed:
```
php artisan migrate --path=database/migrations/2025_05_08_193340_add_is_active_to_tickets_table.php
php artisan migrate --path=database/migrations/2025_05_08_185410_add_completed_to_booking_status_enum.php
```

### 7. (Optional) Seed the Database
```
php artisan db:seed
```

### 8. Link Storage (for QR codes and uploads)
```
php artisan storage:link
```

### 9. Build Frontend Assets
```
npm run build
```

### 10. Start the Development Server
```
php artisan serve
```
Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

## API Usage
- All API endpoints are under `/api` and require authentication (use Laravel Sanctum tokens).
- See `Event-Management-System.postman_collection.json` for example requests.

## Required Libraries & Packages

To install all required libraries and packages, run the following commands:

**PHP (Composer) dependencies:**
```
composer install
```

**JavaScript (npm) dependencies:**
```
npm install
```

This will automatically install:
- Laravel Framework
- Laravel Sanctum (API authentication)
- Bootstrap (UI)
- chillerlan/php-qrcode (QR code generation)
- All other dependencies listed in `composer.json` and `package.json`

If you need to install a specific package manually, use:
- For PHP: `composer require vendor/package-name`
- For JS: `npm install package-name`

## Troubleshooting
- If you see errors about missing columns, run the relevant migrations as shown above.
- Clear caches if you make changes:
  ```
  php artisan config:clear
  php artisan cache:clear
  php artisan view:clear
  php artisan route:clear
  ```
- For permission issues on storage, ensure `storage` and `bootstrap/cache` are writable.

## Contribution
Pull requests are welcome! For major changes, please open an issue first.

## License
This project is open-sourced under the MIT license.
