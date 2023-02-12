## Laravel Simple CMS

This is a simple content management system (CMS) created using Laravel 9 & Livewire.

## Want to test it ?

Here are the credentials for some users:

-   Email: admin@example.com / Password: 123456789
-   Email: bob@esi.dz / Password: 123456789

## How to launch the app

-   Start with `composer install` in the root folder & `npm install` in the websocket folder to install dependencies.
-   Launch the migrations and the seeders `php artisan migrate --seed`.
-   Go to the websocket folder and launch the command `npm start`.
-   then finaly launch the command `php artisan serve`.

## What you will find

-   Jetstream Auth
-   Many CRUDs (Pages CRUD, Users CRUD...)
-   Role permissions managment
-   Notification push using nodejs & web sockets
-   Custom commande to create livewire CRUD components : `php artisan make:livewire:crud [class-name] [model-name]`
