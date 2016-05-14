<?php
namespace TerraMonitoring\Web\Log;
use Doctrine\DBAL\Driver\PDOException;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Doctrine\DBAL\Logging\DebugStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogServiceProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        if ( $app['debug'] ) {
            $logger = new DebugStack();
            $app['db.config']->setSQLLogger($logger);
            $app->error(function(\Exception $e, $code) use ($app, $logger) {
                if ( $e instanceof PDOException and count($logger->queries) ) {
                    // We want to log the query as an ERROR for PDO exceptions!
                    $query = array_pop($logger->queries);
                    $app['monolog']->err($query['sql'], array(
                        'params' => $query['params'],
                        'types' => $query['types']
                    ));
                }
            });
            $app->after(function(Request $request, Response $response) use ($app, $logger) {
                // Log all queries as DEBUG.
                foreach ( $logger->queries as $query ) {
                    $app['monolog']->debug($query['sql'], array(
                        'params' => $query['params'],
                        'types' => $query['types']
                    ));
                }
            });
        }
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}

