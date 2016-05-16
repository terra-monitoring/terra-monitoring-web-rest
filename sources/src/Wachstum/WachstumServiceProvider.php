<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:19
 */

namespace TerraMonitoring\Web\Wachstum;

use Silex\Application;
use Silex\ServiceProviderInterface;

class WachstumServiceProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['repo.wachstum'] = $app->share(function (Application $app) {
            return new WachstumRepository($app['db']);
        });
        $app['service.wachstum'] = $app->share(function () use ($app) {
            return new WachstumService($app['repo.wachstum']);
        });
        $app->mount('/wachstum', new WachstumRoutesProvider());
    }
    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}