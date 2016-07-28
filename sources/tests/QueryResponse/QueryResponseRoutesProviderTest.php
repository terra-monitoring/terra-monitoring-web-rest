<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 26.07.16
 * Time: 10:31
 */

namespace TerraMonitoring\Web\Fuetterung;


use Silex\ControllerCollection;
use TerraMonitoring\Web\Application;
use TerraMonitoring\Web\QueryResponse\QueryResponseRoutesProvider;

class QueryResponseRoutesProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function registerIndexRoute()
    {
        $provider = new QueryResponseRoutesProvider();
        /** @var ControllerCollection $controllerFactory */
        $controllerFactory = $this->prophesize(ControllerCollection::class);
        $controllerFactory->get('/{from}/{to}', 'service.queryResponse:getBetween')
            ->shouldBeCalled()
        ;
        $app                        = new Application();
        $app['controllers_factory'] = $controllerFactory->reveal();
        $provider->connect($app);
    }
}