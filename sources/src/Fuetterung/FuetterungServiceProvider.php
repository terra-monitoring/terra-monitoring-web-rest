<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:19
 */

namespace TerraMonitoring\Web\Fuetterung;

use Silex\Application;
use Silex\ServiceProviderInterface;

class FuetterungServiceProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['repo.fuetterung'] = $app->share(function (Application $app) {
            return new FuetterungRepository($app['db']);
        });
        $app['service.fuetterung'] = $app->share(function () use ($app) {
            return new FuetterungService($app['repo.fuetterung']);
        });
        $app->mount('/fuetterung', new FuetterungRoutesProvider());
    }
    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}