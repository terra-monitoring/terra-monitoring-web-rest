<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 24.04.16
 * Time: 23:00
 */

namespace TerraMonitoring\Web\Controller;


use Symfony\Component\HttpFoundation\Response;

class StatsController
{
    public function index() {
        return new Response("StatsController::index");
    }
}