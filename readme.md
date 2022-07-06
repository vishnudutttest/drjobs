Follow the Steps

Set the database details
migrate database "php artisan migrate"
create 10 user manually (You can do with register form)
Convert one user to admin manually (from database change the type =1)
run the post_category seeder "php artisan db:seed --class=PostCategorytable"
rund the Post seeder "php artisan db:seed --class=PostTableSeeder"

Go to the login page

Admin
Login with Admin - 
    List Users (edit,delete,approve) with ajax pagination
    List All Posts (delete) with ajax pagination
Login with User - after approval from the Admin login otherwise shows error (ajax)
    List post as Dashboard (pagination with ajax)
    you can delete only your on post

NOTE : 
Used Gate for the Autherization