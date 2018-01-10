<?php
namespace Multt\Generators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEloquentCommand();
    }

    protected function registerEloquentCommand()
    {
        $this->app->singleton('multt.generators.commands.eloquent_command', function ($app) {
            return $app['Multt\Generators\Commands\EloquentCommand'];
        });
        $this->commands('multt.generators.commands.eloquent_command');
    }
}
