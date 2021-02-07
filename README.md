## Installation

The default installation instructions are as following, if your environment supports [Laravel Sail](https://laravel.com/docs/8.x/sail) please move to the next step.

```bash
    composer install
    composer run post-root-package-install
    composer run post-create-project-cmd
    
    npm install
    npm run dev
    
    php artisan migrate --seed
    php artisan serve
```

I added [Laravel Sail](https://laravel.com/docs/8.x/sail) in favor of a faster setup. If you have Docker,
you'll need to stop your running database and web servers, then run

```bash
  ./vendor/bin/sail up
  ./vendor/bin/sail artisan migrate --seed
 
  ./vendor/bin/sail npm install
  ./vendor/bin/sail npm run dev
```

Now you should be able to access the website at `http://localhost`.

If you don't have Laravel Sail, you will need a database named `blogtest`, and have a running Redis server, or you can switch the driver to any other cache service installed in your environment.


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
