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

class FuetterungRoutesProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function registerIndexRoute()
    {
        $provider = new FuetterungRoutesProvider();
        /** @var ControllerCollection $controllerFactory */
        $controllerFactory = $this->prophesize(ControllerCollection::class);
        $controllerFactory->get('/', 'service.fuetterung:readAll')->shouldBeCalled();
        $controllerFactory->get('/{date}', 'service.fuetterung:read')
            ->shouldBeCalled()
        ;
        $controllerFactory->post('/', 'service.fuetterung:create')
            ->shouldBeCalled()
        ;
        $controllerFactory->put('/{date}', 'service.fuetterung:update')
            ->shouldBeCalled()
        ;
        $controllerFactory->get('/totalConsum', 'service.fuetterung:totalConsum')
            ->shouldBeCalled()
        ;
        $app                        = new Application();
        $app['controllers_factory'] = $controllerFactory->reveal();
        $provider->connect($app);
    }
}