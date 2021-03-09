# Opiner

A simple Twitter clone built with Laravel 8.

##### Home
###### Desktop
![Home Desktop](https://i.imgur.com/6Ygu7vN.png)
###### Desktop Dark
![Home Desktop Dark](https://i.imgur.com/aio0lWb.png)
###### Mobile
![Home Mobile](https://i.imgur.com/fGlfkf5.png)
###### Mobile Dark
![Home Desktop Dark](https://i.imgur.com/m1hcHcf.png)

##### Explore
###### Desktop
![Explore Desktop](https://i.imgur.com/A4B2MeW.png)
###### Desktop Dark
![Explore Desktop Dark](https://i.imgur.com/dBZuVit.png)
###### Mobile
![Explore Mobile](https://i.imgur.com/RGUj03n.png)
###### Mobile Dark
![Explore Desktop Dark](https://i.imgur.com/r7WG9ZU.png)

##### Notifications
###### Desktop
![Notifications Desktop](https://i.imgur.com/IVttFw2.png)
###### Desktop Dark
![Notifications Desktop Dark](https://i.imgur.com/d9zw3q9.png)
###### Mobile
![Notifications Mobile](https://i.imgur.com/7u3spSo.png)
###### Mobile Dark
![Notifications Desktop Dark](https://i.imgur.com/ZDrTRyA.png)

##### Profile
###### Desktop
![Profile Desktop](https://i.imgur.com/TSUJEN6.png)
###### Desktop Dark
![Profile Desktop Dark](https://i.imgur.com/Ra3z4Oj.png)
###### Mobile
![Profile Mobile](https://i.imgur.com/Mcc5a0Z.png)
###### Mobile Dark
![Profile Desktop Dark](https://i.imgur.com/vVmkwqH.png)

##### Opinion
###### Desktop
![Opinion Desktop](https://i.imgur.com/jSNWXjB.png)
###### Desktop Dark
![Opinion Desktop Dark](https://i.imgur.com/s3OpX6r.png)
###### Mobile
![Opinion Mobile](https://i.imgur.com/1Gnd33g.png)
###### Mobile Dark
![Opinion Desktop Dark](https://i.imgur.com/VZL1vo4.png)

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
