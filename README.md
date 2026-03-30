# Infinity Tasks - Task Manager

A modern task management application built with Laravel.

## Features

- Create, view, and manage tasks
- Task prioritization (High, Medium, Low)
- Status progression: Pending → In Progress → Done
- Daily task reports with summary statistics
- Responsive dark-themed UI

## Requirements

- PHP 8.2+
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js 18+ (optional, for asset compilation)

## How to Run Locally

### 1. Clone and Install Dependencies

```bash
git clone https://github.com/BRAYOgith/Brian-Njoki-TaskManager
cd task-manager
composer install
```

### 2. Configure Environment

Copy the environment file:

```bash
cp .env.example .env
```

Update `.env` with your MySQL settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Create Database

Create a MySQL database:

```sql
CREATE DATABASE task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Run Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed
```

### 5. Start the Server

```bash
php artisan serve
```

Access the app at `http://localhost:8000`

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/tasks` | List all tasks (optional: `?status=pending`) |
| POST | `/api/tasks` | Create a task |
| PATCH | `/api/tasks/{id}/status` | Update task status |
| DELETE | `/api/tasks/{id}` | Delete a completed task |
| GET | `/api/tasks/report?date=YYYY-MM-DD` | Get daily report summary |

### Create Task Request Body

```json
{
  "title": "Task title",
  "due_date": "2026-03-30",
  "priority": "high"
}
```

### Daily Report Response

```json
{
  "date": "2026-03-28",
  "summary": {
    "high": {"pending": 2, "in_progress": 1, "done": 0},
    "medium": {"pending": 1, "in_progress": 0, "done": 3},
    "low": {"pending": 0, "in_progress": 0, "done": 1}
  }
}
```

## Deployment

### Railway

1. **Create Railway Project**
   - Go to [Railway](https://railway.app)
   - Create a new project
   - Add a MySQL database
   - Deploy from GitHub

2. **Set Environment Variables**
   In Railway dashboard, set:
   ```
   APP_KEY=<generate with php artisan key:generate>
   DB_HOST=<your-mysql-host>
   DB_PORT=3306
   DB_DATABASE=task_manager
   DB_USERNAME=<your-username>
   DB_PASSWORD=<your-password>
   ```

3. **Run Migrations**
   Use Railway's terminal:
   ```bash
   railway run php artisan migrate
   railway run php artisan db:seed
   ```

### Render

1. **Create Render Account**
   - Go to [Render](https://render.com)
   - Create a new Web Service
   - Connect your GitHub repository

2. **Configure Settings**
   - Build Command: `composer install`
   - Publish Directory: `public`
   - Start Command: `php artisan serve --port=$PORT`

3. **Add Environment Variables**
   - `APP_KEY`
   - `APP_DEBUG=false`
   - `APP_URL=<your-render-url>`
   - Database credentials

4. **Create MySQL Database**
   - Create a Render PostgreSQL or MySQL instance
   - Copy the connection details to your web service

5. **Run Migrations**
   Use Render Shell:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

### Generic VPS (Ubuntu)

1. **Install Dependencies**
   ```bash
   sudo apt update
   sudo apt install php8.2 php8.2-cli php8.2-mysql php8.2-xml php8.2-mbstring unzip
   composer global require laravel/installer
   ```

2. **Configure Nginx**
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /var/www/task-manager/public;
       
       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";
       
       index index.php;
       
       charset utf-8;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
   }
   ```

3. **Deploy**
   ```bash
   git clone <repository-url> /var/www/task-manager
   cd /var/www/task-manager
   composer install --optimize-autoloader
   php artisan key:generate
   # Configure .env with production database
   php artisan migrate --force
   php artisan db:seed --force
   sudo systemctl restart nginx
   ```

## Troubleshooting

**Migrations failing?** - Ensure the database exists and credentials are correct.

**CSS/JS not loading?** - Run `php artisan storage:link` and check file permissions.

**API returns 419?** - Ensure CSRF token is included in forms or use API routes.

## License

MIT
