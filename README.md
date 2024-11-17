
# Blog CRUD Assignment

## Installation

1. Clone the Repository
2. Composer Install
3. Copy .env.example file to .env    ( I have copied the .env data to .env.example for push to github )
4. Change DB name, DB user, DB password in .env 
5. run these commands 
---     php artisan key:generate 
---    php artisan migrate
--- php artisan passport:install    ( run -  composer require laravel/passport -- if required  ) 


## Mysql file is in the DB_file folder

# Overview

Setup a migration for posts (create_posts_table) with title, content, author, timestamps (created_at, updated_at), softdelete (deleted_at).

1. All routes under the authenticated section require the user to be logged in with a valid API token. These routes are secured with the auth:api middleware
2. I use blogs prefix for grouping all endpoints.
3. POST /blogs/create: Creates a new blog post. Requires authenticated user.
4. GET /blogs/list: Retrieves a list of all blog posts.
5. POST /blogs/update: Updates an existing blog post.
6. GET /blogs/details/{id}: Retrieves details of a specific blog post by its ID.
7. GET /blogs/delete/{id}: Deletes a blog post by its ID.

## Additional 
1. Setup a controller named AuthController for login API

2. Setup a controller named PostController for all blog posts APIs.

3. On creating the new Post a event will trigger which sends notification to test user via email with post data ( for email i used log driver MAIL_MAILER=log also mailtrap for testing ).

4. A new weekly Task is scheduled for sendign email of weekly summary that compiles all posts from past week. for automatically run schedule run this command on local ```php artisan schedule:work ``` and on server we need to add cron. (scheduled command is setup in the bootstrap/app.php - to run directly run this command -- ``` php artisan email:weekly-summary ```)

5. A unit test is setup for checking the post Validation of creating the post ( unit test function named test_post_requires_title_and_content )

6. Feature test is setup for creating the POST and another feature test for updating the post ( test_create_post && test_update_post ).


## New Functionality
1. Created a Login/Register Pages for authentication using Laravel breeze, for css here tailwind css is used because breeze used tailwind by its default.

2. created new routes for CRUD view and functionalities under auth middleware .

3. Profile routes for user profile information, update password, delete account - this functionality is deffault given by laravel breeze.


