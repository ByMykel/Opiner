# Opiner

A simple project that attempt to clone Twitter using Laravel 8.

##### Home
![Home](https://i.imgur.com/dHSG7ZB.png)

##### Explore
![Explore](https://i.imgur.com/Us7Mf4N.png)

##### Notifications
![Notifications](https://i.imgur.com/sLwhoxh.png)

##### Profile
![Profile](https://i.imgur.com/PY7RQF3.png?1)

##### Opinion
![Opinion](https://i.imgur.com/g6oJfsa.png)

### Install
Clone the git repository on your computer and install it's dependencies
```
$ git clone https://github.com/ByMykel/Opiner.git
$ cd Opiner
$ composer install
```

### Setup
- When you are done with installation, copy the `.env.example` file to `.env`
```
$ cp .env.example .env
```

- Generate the application key
```
$ php artisan key:generate
```

- Add your database credentials to the necessary `env` fields

- Migrate the application
```
$ php artisan migrate
```

- Seed Database
```
$ php artisan db:seed
```

- Install dependencies and build assets
```
$ npm install && npm run dev
```

### Run the application
```
$ php artisan serve
```