<?php

namespace Tests\Api;

use Fan\Laty\Laravel\ApiTestCase;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use App\Models\User;
// use App\Services\RecaptchaService;

class WebServiceTest extends ApiTestCase
{
    public function webServiceAutomatedProvider()
    {
        return $this->apiControllerAutomatedProvider(static::getConfigPrefix());
    }

    /**
    * @param array $seeds database seeds
    * @param string $method HTTP method
    * @param string $uri URI
    * @param array $parameters request parameters
    * @param array $cookies request cookies
    * @param array $files files posted
    * @param array $server server parameters
    * @param string $content data posted
    * @param unknown $checks
    * @dataProvider webServiceAutomatedProvider
    */
    public function testWebServices($seeds, $method, $uri, $parameters, $cookies, $files, $server, $content, $checks, $test_id)
    {
        return $this->apiControllerAutomatedTest($seeds, $method, $uri, $parameters, $cookies, $files, $server, $content, $checks, $test_id);
    }

    protected static function getConfigPaths()
    {
        return array(__DIR__.'/specs/');
    }

    protected static function getConfigPrefix()
    {
        return 'api_controller_actions';
    }

    protected function authenticateUser($user_name, $server)
    {
        $user = $this->getUser($user_name);

        if (! is_null($user)) {
            // $scopes = array_keys(config('auth.scopes.' . Str::snake($user->role->role_name)));
            Passport::actingAs($user);
        }

        return $server;
    }

    private function getUser($user_name)
    {
        return User::find($user_name);
    }

    protected function getAuthenticatedUser()
    {
        return Auth::user();
    }

    protected function prepareCache(array $checks)
    {
        /*if (isset($checks['cache']))
        {
            $driver = array_key_exists('driver', $checks['cache']) ? $checks['cache']['driver'] : 'redis';
            $this->app['cache']->setDefaultDriver($driver); // override 'array' in phpunit.xml

            foreach ($checks['cache'] as $m => $key)
            {
                if ($m === 'cleanKey')
                {
                    list($repositoryClass, $rest) = explode('@', $key);
                    CacheKeys::putKey($repositoryClass, $key);
                    Cache::put($key, str_random(128), config('repository.cache.minutes')); // fake a cache for cleaning check
                }
                else
                {
                    Cache::forget($key); // clear cache just in case
                }
            }
        }*/
    }

    /* protected function dbsBeginTransaction()
    {
        $parentDb = parent::dbsBeginTransaction();

        $db = DB::connection(env('WP_DB_NAME'));
        $db->beginTransaction();

        return array_merge($parentDb, [$db]);
    } */


    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // $app->bind(RecaptchaService::class, function() {
        //     return new RecaptchaServiceMock();
        // });

        return $app;
    }
}

// class RecaptchaServiceMock extends RecaptchaService
// {
//     public function assessRequest(string $token, string $action)
//     {
//         // do nothing in this service mock
//     }
// }
