@echo off

title PHP Server and Queue Worker

:: Lancer la commande 'php artisan queue:work' en arrière-plan avec un titre "Queue Worker"
start /b php artisan serve

:: Lancer la commande 'php artisan serve' en arrière-plan avec un titre "PHP Server"
start /b npm run dev

start /max cmd

exit
