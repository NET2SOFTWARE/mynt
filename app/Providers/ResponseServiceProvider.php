<?php

namespace App\Providers;

use const false;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use const null;
use const true;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory $factory
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', function ($data = [], $status = 200, array $headers = [], $options = 0) use ($factory) {

            $customFormat = (array) [
                'status' => is_null($data) ? false : true,
                'message' => config('code.'. $status),
                'data' => $data
            ];

            return $factory->json($customFormat, $status, $headers, $options);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
