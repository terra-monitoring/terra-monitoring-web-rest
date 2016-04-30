<?php

namespace TerraMonitoring\Web;

use Basster\Silex\Provider\Swagger\SwaggerProvider;
use Basster\Silex\Provider\Swagger\SwaggerServiceKey;
use Silex\Application as Silex;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Sorien\Provider\PimpleDumpProvider;
use Swagger\Annotations as SWG;
use SwaggerUI\Silex\Provider\SwaggerUIServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use TerraMonitoring\Web\Fuetterung\FuetterungServiceProvider;

/**
 * @package TerraMonitoring\Web
 * @SWG\Info(title="My First API", version="0.1")
 */

/**
 * @SWG\Get(
 *     path="/v1/resource.json",
 *     @SWG\Response(response="200", description="An example resource")
 * )
 */
class Application extends Silex {

    public function __construct(array $values = [])
    {
        parent::__construct($values);
        $this->setup($this);
    }

    private function setup($app)
    {
        $app['base_path'] = __DIR__;
        // Set debug mode
        $this["debug"] = true;
        $this->register(new ServiceControllerServiceProvider());
        // http://silex.sensiolabs.org/doc/cookbook/json_request_body.html
        $this->before(function (Request $request) use ($app) {
            if (Util::requestIsJson($request)) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        });
        // Register Pimple Dump Provider for IntelliJ auto complete on DI container.
        $this->register(new PimpleDumpProvider());
        $this->register(new SwaggerProvider(), [
            SwaggerServiceKey::SWAGGER_SERVICE_PATH => $app['base_path'],
            SwaggerServiceKey::SWAGGER_API_DOC_PATH => '/docs/swagger.json',
        ]);
        // Set up swagger ui service for viewing the swagger docs
        $app->register(new SwaggerUIServiceProvider(), array(
            'swaggerui.path' => '/docs/swagger',
            'swaggerui.docs' => '/docs/swagger.json',
        ));
        $app->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/einstein.db',
            ),
        ));
        $app['databaseSetup'] = $app->share(function() use ($app) {
            // Retrieve the db instance and create an instance of myClass
            return new DatabaseSetup($app['db']);
        });

        $this->register(new FuetterungServiceProvider() );
    }
}
