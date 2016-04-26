<?php

namespace TerraMonitoring\Web;

use Silex\Application as Silex;
use Silex\Provider\ServiceControllerServiceProvider;
use Sorien\Provider\PimpleDumpProvider;
use Symfony\Component\HttpFoundation\Request;

class Application extends Silex {

    public function __construct(array $values = [])
    {
        parent::__construct($values);
        $this->setup($this);

    }

    private function setup($app)
    {
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
    }
}
