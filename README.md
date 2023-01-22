# Laravel task



Use the repository design pattern to develop the blow,
Login form:- the scenario will be as following
- if the user tries to enter his password 3 times wrong, an error message should say try again after 30 sec.
- if he tries again with a correct password for sure pass him, otherwise, the account should be blocked.

- List the users in a simple table with indexing two columns and order by both indexes


Also develop a simple postman API, to login the user from just two devices at the same time, so that he can't login from a third device.
If he tries to login from a third device return a message that says "You're logged in from two devices", otherwise log him in normally.
----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker).

Clone the repository

    git clone https://github.com/AhmedYasser2019/hwzntask.git

Switch to the repo folder

    cd hwzntask

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/AhmedYasser2019/hwzntask.git
    cd hwzntask
    composer install
    cp .env.example .env
    php artisan key:generate

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Open the UerDataSeeder and set the property values as per your requirement

    database/seeds/UserDataSeeder.php

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh


The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).


# Code overview


## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|

Refer the [api specification](#api-specification) for more info.

----------


