# Employee Leave Management

Employee Leave Management Planner Software

## Installation

If you need to install php and composer, use any of the official [PHP](https://www.php.net/downloads.php) and
[Composer](https://getcomposer.org/download/) installers provided for your operating system.

Clone the project repository:

```bash
git clone git@github.com:salihbasakk/leave-management.git
```
Create .env file from .env.dist (with related database configuration)
Example: 

DATABASE_NAME=leave-management
DATABASE_ROOT_PASSWORD=123456!
DATABASE_PORT=3306

```bash
docker-compose up -d --build
```

```bash
docker exec -it php-app /bin/sh
```

```bash
php bin/console doctrine:migrations:migrate
```

```bash
bin/console lexik:jwt:generate-keypair
```

You can use postman collection leaveManagement.postman_collection.json for request




