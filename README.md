# Some game

Don't have a name yet but a game yay

## Installation
If for whatever reason you want to install this game on your own computer, here's instructions on how to do it. 
Instructions on how to contribute to the project are below

### Requirements
In order for this game to be ran, you need the following:
* Git (lol ofc)
* PHP 7
* Composer
* MySql 5.7

### Instructions
First, clone the repository

    git clone https://github.com/Yosodog/game.git

Then enter the newly created directory

Install the dependencies:
    
    composer install

If you haven't installed composer globally, the command is:

	php composer.phar install
    
Copy the .env.example file and rename it to .env

    cp .env.example .env
    
Open the .env file and fill out the DB_* fields.

Once you've done that, make sure you have a database setup

Now run the migrations:

    php artisan migrate
    
Once that is done, seed the tables by running the following seeders in this order:

    php artisan db:seed --class=FlagTableSeeder
    php artisan db:seed --class=PropertiesSeeder
    php artisan db:seed --class=BuildingTypesSeeder
    
Finally, generate a key for Laravel

    php artisan key:generate
    
And congratulations, you have a local copy of the game

## Contributing

I'm happy you want to contribute to the game, because I don't really want to. First, you should contact Yosodog about
contributing. Tell me what you want to do and stuff like that. Then, fork the repo, make your changes, and submit a pull request.
Make sure that your changes follow the general code style. I'm not going to be a prick about it, but make sure that it looks generally the same.
Also, make sure that your code follows proper "Laravel" things, like using migrations for database changes and such.
Like I said, I'm not going to be a prick, but make sure your changes aren't bad.