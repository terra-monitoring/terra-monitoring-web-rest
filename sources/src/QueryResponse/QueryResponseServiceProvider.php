<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:19
 */

namespace TerraMonitoring\Web\QueryResponse;

use Silex\Application;
use Silex\ServiceProviderInterface;

class QueryResponseServiceProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['service.queryResponse'] = $app->share(function () use ($app) {
            return new QueryResponseService($app['repo.wachstum'], $app['repo.fuetterung']);
        });
        $app->mount('/queryResponse', new QueryResponseRoutesProvider());
    }

    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}