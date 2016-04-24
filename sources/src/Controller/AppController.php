<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 24.04.16
 * Time: 22:14
 */
namespace TerraMonitoring\Web\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class AppController
{
    public function homeAction() {
        return new Response("AppController::homeAction");
    }


    public function helloAction(Application $app, $name) {
        return new Response("Hello " . $app->escape($name) );
    }
}