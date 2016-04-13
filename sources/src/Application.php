<?php

namespace HsBremen\WebApi;

use Silex\Application as Silex;

class Application extends Silex {

    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this->get('/', function() {
            return 'Hello World';
        });
    }
}
