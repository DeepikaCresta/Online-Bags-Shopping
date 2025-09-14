## Setup

### Step 1

```
    composer install
    cp .env.example
    npm install
```

### Step 2

Connect your database in the by updating the environment variable for database in .env

### Step 3

```
    php artisan key:generate
    php aritisan migrate
    php artisan db:seed //if you have seeder in your seeder folder
```

### Step 4

Run the project
```
    npm run dev && php artisan serve
```

## Esewa Credentials

eSewa ID: 9806800001/2/3/4/5
Password: Nepal@123
Token:123456