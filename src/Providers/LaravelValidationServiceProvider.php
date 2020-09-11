<?php

namespace Whitegfx\LaravelValidation\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //php artisan vendor:publish --provider="Whitegfx\LaravelValidation\Providers\LaravelValidationServiceProvider" --tag=json

        /**
         * Config
         *
         * Uncomment this function call to make the config file publishable using the 'config' tag.
         */
        // $this->publishes([
        //     __DIR__.'/../../config/laravel-validation.php' => config_path('laravel-validation.php'),
        // ], 'config');

        /**
         * Routes
         *
         * Uncomment this function call to load the route files.
         * A web.php file has already been generated.
         */
        // $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        /**
         * Translations
         *
         * Uncomment the first function call to load the translations.
         * Uncomment the second function call to load the JSON translations.
         * Uncomment the third function call to make the translations publishable using the 'translations' tag.
         */
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'laravel-validation');
        // $this->loadJsonTranslationsFrom(__DIR__.'/../../resources/lang', 'laravel-validation');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/laravel-validation'),
        ], 'translations');

        /**
         * Views
         *
         * Uncomment the first section to load the views.
         * Uncomment the second section to make the view publishable using the 'view' tags.
         */
        // $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-validation');
        // $this->publishes([
        //     __DIR__.'/../../resources/views' => resource_path('views/vendor/laravel-validation'),
        // ], 'views');

        /**
         * Commands
         *
         * Uncomment this section to load the commands.
         * A basic command file has already been generated in 'src\Console\Commands\MyPackageCommand.php'.
         */
        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         \Whitegfx\LaravelValidation\Console\Commands\LaravelValidationCommand::class,
        //     ]);
        // }

        /**
         * Public assets
         *
         * Uncomment this functin call to make the public assets publishable using the 'public' tag.
         */
        // $this->publishes([
        //     __DIR__.'/../../public' => public_path('vendor/laravel-validation'),
        // ], 'public');

        $this->publishes([
            __DIR__ . '/../../resources/json' => resource_path('vendor/laravel-validation/json'),
        ], 'json');

        /**
         * Migrations
         *
         * Uncomment the first function call to load the migrations.
         * Uncomment the second function call to make the migrations publishable using the 'migrations' tags.
         */
        // $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        // $this->publishes([
        //     __DIR__.'/../../database/migrations/' => database_path('migrations')
        // ], 'migrations');

        // $this->app->validator->resolver(function ($translator, $data, $rules, $messages) {
        //     return new DisposableEmail($translator, $data, $rules, $messages);
        // });
        $this->registerValidationRules($this->app['validator']);
        /*

        public function boot()
        {
            $this->registerValidationRules($this->app['validator']);
        }

        protected function registerValidationRules(\Illuminate\Contracts\Validation\Factory $validator)
        {
            $validator->extend('zip', 'Gvt\Support\Validators\GvtRuleValidator@validateZip');
            $validator->extend('state', 'Gvt\Support\Validators\GvtRuleValidator@validateStateCode');
            $validator->extend('phone', 'Gvt\Support\Validators\GvtRuleValidator@validatePhone');
            $validator->extend('county', 'Gvt\Support\Validators\GvtRuleValidator@validateCounty');
            $validator->extend('party', 'Gvt\Support\Validators\GvtRuleValidator@validatePoliticalParty');
            $validator->extend('ballot_style', 'Gvt\Support\Validators\GvtRuleValidator@validateBallotStyle');
        }

        */
    }

    protected function registerValidationRules(\Illuminate\Contracts\Validation\Factory $validator)
    {
        // $validator->replacer('disposable_email', function ($message, $attribute, $rule, $parameters) {
        //     // var_dump($message);
        //     //trans("validation.disposable_email");
        //     //exit;
        //     return str_replace('validation.disposable_email', trans("validation.disposable_email"), $message);
        // });
        $validator->extend('disposable_email', 'Whitegfx\LaravelValidation\Rules\DisposableEmail@validateDisposableEmail', trans("laravel-validation::validation.disposable_email"));
        $validator->extend('zip_code', 'Whitegfx\LaravelValidation\Rules\ZipCode@validateZipCode', trans("laravel-validation::validation.zip_code"));
        $validator->extend('record_owner', 'Whitegfx\LaravelValidation\Rules\RecordOwner@validateRecordOwner', trans("laravel-validation::validation.record_owner"));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Config file
         *
         * Uncomment this function call to load the config file.
         * If the config file is also publishable, it will merge with that file
         */
        // $this->mergeConfigFrom(
        //     __DIR__.'/../../config/laravel-validation.php', 'laravel-validation'
        // );
    }
}
