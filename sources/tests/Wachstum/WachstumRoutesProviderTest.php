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
use TerraMonitoring\Web\Wachstum\WachstumRoutesProvider;

class WachstumRoutesProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function registerIndexRoute()
    {
        $provider = new WachstumRoutesProvider();
        /** @var ControllerCollection $controllerFactory */
        $controllerFactory = $this->prophesize(ControllerCollection::class);
        $controllerFactory->get('/', 'service.wachstum:readAll')->shouldBeCalled();
        $controllerFactory->get('/{date}', 'service.wachstum:read')
            ->shouldBeCalled()
        ;
        $controllerFactory->post('/', 'service.wachstum:create')
            ->shouldBeCalled()
        ;
        $controllerFactory->put('/{date}', 'service.wachstum:update')
            ->shouldBeCalled()
        ;
        $controllerFactory->get('/gewicht/max', 'service.wachstum:max')
            ->shouldBeCalled()
        ;
        $controllerFactory->get('/{from}/{to}', 'service.wachstum:getBetween')
            ->shouldBeCalled()
        ;
        $app                        = new Application();
        $app['controllers_factory'] = $controllerFactory->reveal();
        $provider->connect($app);
    }
}
