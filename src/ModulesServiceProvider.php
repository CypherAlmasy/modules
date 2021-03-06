<?php

namespace Caffeinated\Modules;

use Caffeinated\Modules\Modules;
use Caffeinated\Modules\Contracts\Repository;
use Caffeinated\Modules\Providers\ConsoleServiceProvider;
use Caffeinated\Modules\Providers\GeneratorServiceProvider;
use Caffeinated\Modules\Providers\HelperServiceProvider;
use Caffeinated\Modules\Providers\MigrationServiceProvider;
use Caffeinated\Modules\Providers\RepositoryServiceProvider;
use Illuminate\Support\ServiceProvider;
use Caffeinated\Modules\Repositories\EloquentRepository;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * @var bool Indicates if loading of the provider is deferred.
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->resolving(
            EloquentRepository::class,
            function(EloquentRepository $repository, $app) {
                return $repository->setModel(
                    $app->make(config('modules.model'))
                );
            }
        );
        
        $this->publishes([
            __DIR__.'/../config/modules.php' => config_path('modules.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->app->singleton('modules', function ($app) {
            $repository = $app->make(Repository::class);

            return new Modules($app, $repository);
        });
        
        $this->app['modules']->register();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/modules.php', 'modules'
        );

        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(GeneratorServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);
        $this->app->register(MigrationServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string
     */
    public function provides()
    {
        return ['modules'];
    }

    public static function compiles()
    {
        $modules = app()->make('modules')->all();
        $files   = [];

        foreach ($modules as $module) {
            $serviceProvider = module_class($module['slug'], 'Providers\\ModuleServiceProvider');

            if (class_exists($serviceProvider)) {
                $files = array_merge($files, forward_static_call([$serviceProvider, 'compiles']));
            }
        }

        return array_map('realpath', $files);
    }
    
}
