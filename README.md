## Installation

### Laravel Sail

I added [Laravel Sail](https://laravel.com/docs/8.x/sail) in favor of a faster setup. You'll need to stop your running database and web servers with conflicting ports, then run:

```bash
composer install
composer run post-root-package-install
composer run post-create-project-cmd
./vendor/bin/sail up -d

./vendor/bin/sail npm install
./vendor/bin/sail npm run dev

sleep 60s # The MySQL service may need a minute or so to start 
./vendor/bin/sail artisan migrate --seed
```

Now you should be able to access the website at `http://localhost/`.

### Manual Setup

If you don't have Laravel Sail, you will need to configure the ``MYSQL_HOST`` and ``REDIS_HOST`` to ``127.0.0.1`` in the ``.env`` file. Also, you'll need to create a database named ``blogtest`` and a running Redis server or any other cache driver you wish to configure.

```bash
composer install
composer run post-root-package-install
composer run post-create-project-cmd

npm install
npm run dev

php artisan migrate --seed
php artisan serve
```

## Using the application

You can log in with the email ``admin@blog.com`` and password ``password``. 

## Import Feature

You can import posts from the feed API by running:

```bash
    php artisan feed:import
```

### Task Schedule

The import command is ran by Laravel's task scheduler every 5 minutes, you can change this number in the environment
file or in the ``config/post.php`` configuration file. In order to run Laravel's task scheduler, you have two options:

- Add this cron entry: ``* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1``

- Run the scheduler in the background: ``php artisan schedule:work``

### Flow chart

I put together a diagram in order to illustrate how this process works, and give you a general idea of what's going on.

![alt text](https://github.com/mauriciovillam/blog/blob/master/importer-diagram.png?raw=true)

## Takeaways

### Cache Strategy

The case scenario mentions that the website expects to receive millions of visitors each month, and we need to minimize the strain put on our system and at the feed API whenever we can. There are many ways to approach this, however after analyzing the scenario for a while I concluded that, considering there are 2-3 new posts each hour, and we have no way to know immediately when there is a new post, the best solution is to use an interval between each import.

Ideally, we should calculate a median interval between posts publications date, but I came up with a reasonable number -namely, 5 minutes-, based on the fact it may take up to 20-30 minutes between posts, and we don't want to keep the data outdated for too long. However, it's kind of an arbitrary number, so if 5 minutes seems too long it can be lowered without issues.

The cache is automatically invalidated when a Post is created or updated, whether it was made by an user or it was created by the import process.

Another comment I wanted to leave here: in this case scenario, a package like [laravel-model-caching](https://github.com/GeneaLabs/laravel-model-caching) would have sufficed. However, I assumed that you wanted to test if I could introduce a caching pattern, so I discarded that package.

### Setup Decisions

I decided to move forward with Laravel Breeze in order to scaffold the authentication system and allow me to focus on more important objectives. It is worthy to mention that in other scenario I might have made a REST API with Laravel consumed by a React application.

## Testing

You can run the tests by performing the following command:

```bash
php artisan test
```


## License

[MIT license](https://opensource.org/licenses/MIT)

## Author

- Mauricio Villalobos
