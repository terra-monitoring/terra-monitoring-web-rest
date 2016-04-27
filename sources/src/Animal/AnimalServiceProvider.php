<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:19
 */

namespace TerraMonitoring\Web\Animal;

use Silex\Application;
use Silex\ServiceProviderInterface;

class AnimalServiceProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['service.animal'] = $app->share(function () use ($app) {
            return new AnimalService($app['db']);
        });
        $app->mount('/animal', new AnimalRoutesProvider());
    }
    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}