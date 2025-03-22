<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
    	$_SERVER["SERVER_NAME"] = "solarhrm.com";
    }

    // Builder::macro('toRawSql', function() {
    //     return array_reduce($this->getBindings(), function($sql, $binding) {
    //         return preg_replace('/\?/', is_numeric($binding)
    //             ? $binding
    //             : "'".$binding."'", $sql, 1);
    //     }, $this->toSql());
    // });
}
