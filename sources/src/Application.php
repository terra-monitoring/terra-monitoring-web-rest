<?php

namespace TerraMonitoring\Web;

use Silex\Application as Silex;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class Application extends Silex {

    public function __construct(array $values = [])
    {
        parent::__construct($values);
        $this->setup($this);
        $app = $this;
    }

    private function setup(Silex $app)
    {
        $this->register(new ServiceControllerServiceProvider());
        // Set debug mode
        $this["debug"] = true;
        // http://silex.sensiolabs.org/doc/cookbook/json_request_body.html
        $this->before(function (Request $request) use ($app) {
            if (Util::requestIsJson($request)) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        });
    }
}
