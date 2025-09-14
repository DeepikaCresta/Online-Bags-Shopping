# Gmail Setup

## Step 1

Go to the below link and turn on the 2 factor authentication if it is not on

```
https://myaccount.google.com/security
```

## Step 2

Again go tot the same link and in the searchbar type 'apppasswords'

## Step 3

In the app name field write the name you want to write for eg: Laravel Email Testing, Shopi Mail etc

## Step 4

After that click the create button you will get a 16 character password, copy that and paste it in the .env file in MAIL_PASSWORD

### Below is sample what to change in .env file

This is what there might be initially
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=YOURKEYS@gmail.com
MAIL_PASSWORD=YOURKEYS
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=contact@shopi.com
MAIL_FROM_NAME="Shopi"
```

Below is what you have to do

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=katwalsangam@gmail.com
MAIL_PASSWORD=tgrvpizhuwukyymu
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=katwalsangam@gmail.com
MAIL_FROM_NAME="Shopi"
```

As you see the Mail_Username and Mail_from_address will be your gmail id from where you create the 16-character password.
And in the Mail_password  you will be pasting the 16 character password. Remeber to remove spaces from the 16 character password.

## Step 5

After all this run below command
```
php artisan config:clear
```

and restart the project i.e
```
php artisan serve & npm run dev
```