<?php
namespace Data33\LaravelPoll;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class PollServiceProvider extends ServiceProvider
{
    /**
     * Returns the package's base directory path.
     *
     * @return string
     */
    protected function baseDir()
    {
        return __DIR__ . '/../';
    }

    /**
     * Bootstrap the application events.
     *
     * @param  Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->setPublishables();
    }

    public function register()
    {
        $this->loadStaticFiles();
    }

    public function setPublishables() {
        $this->publishes([
            "{$this->baseDir()}config/polls.php" => config_path('polls.php'),
        ], 'config');

        $this->publishes([
            "{$this->baseDir()}migrations/" => base_path('database/migrations')
        ], 'migrations');

        $this->publishes([
            "{$this->baseDir()}views/" => base_path('resources/views/vendor/data33/laravel-poll')
        ], 'views');
    }

    public function loadStaticFiles() {
        $this->mergeConfigFrom("{$this->baseDir()}config/polls.php", "polls");
    }
}