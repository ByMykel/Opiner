# Opiner

A simple Twitter clone built with VueJS, Laravel 8 and TailwindCSS.

### Images
#### Home
![Home](https://i.imgur.com/O2UzXPD.png)
#### Explore
![Explore](https://i.imgur.com/oyLEsOG.png)
#### Notifications
![Notifications](https://i.imgur.com/OI7zgGA.png)
#### Profile
![Profile](https://i.imgur.com/8okNcJl.png)
#### Opinion
![Opinion](https://i.imgur.com/RiXAhDl.png)

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
