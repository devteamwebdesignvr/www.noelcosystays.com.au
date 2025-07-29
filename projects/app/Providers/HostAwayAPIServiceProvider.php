<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper\HostAwayAPI;

/**
 * Class HelperServiceProvider
 * @package App\Providers
 */
class HostAwayAPIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('HostAwayAPI', function()
        {
            return new HostAwayAPI;
        });
    }
}
