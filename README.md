**Passport-Multiauth-guid Demo** 

This project is an implementation sample using the package Passport-Multiauth and i change the ID from auto increment to GUID field . and I change the behavier of passport when every new token generate , old Token will be expire

**Packages** 

Laravel Framework 6.2 

Laravel Passport ^7.0 

ramsey uuid 3.8 

Passport-Multiauth 5.0 

gladcodes/keygen ^1.1


**Install dependencies:** 

composer install

**Generate the encryption key:** 

php artisan key:generate

Migrate database (Don't forget of configure your database credentials on .env file): php artisan migrate

**Install laravel passport** 

php artisan passport:install

**Using**
 
 To create an access token you can use the route /api/login to create an personal access token and pass mobile and provider (in this case whe have 2 provider stores and users) after this the api give you a small token

To use the route api/token you need pass the params mobile, token and provider. if every params is ok access token is generate.

The oauth/token route just add a new param provider to default laravel passport route.

