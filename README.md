<div align="center">
    <img src="public/android-chrome-192x192.png" />
</div>

# Project Todos

Bring all your team together
---
Connect all your team members together with real time project management system

<a href="http://project-features.herokuapp.com/" target="_blank">Demo</a>

<a href="http://abo3adel.github.io/" target="_blank">MyPortfolio</a>

## Features

- Real Time Connection (any update to a project or it`s todos will notify subscribed team members isnstantly)
- User Roles
- See All active users updating the same project.
- Category system
- Unlimited Projects
- Per Project Team (Create diffrent teams for every project)
- Unlimited Todos

## Installation

### Prerequisites
- Laravel 8
- Livewire 2

Clone the repository

    git clone https://github.com/abo3adel/project-todos.git

Switch to the repo folder

    cd project-todos

Install all the dependencies using composer and npm

    composer install
    npm install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Seed database with fake data
    
    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/abo3adel/project-todos.git
    cd project-todos
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    php artisan serve

## Contribution

Any ideas are welcome. Feel free to submit any issues or pull requests.

## License

MIT: <https://abo3adel.mit-license.org>