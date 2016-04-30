<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:13
 */

namespace TerraMonitoring\Web\Fuetterung;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Swagger\Annotations as SWG;

class FuetterungRoutesProvider implements ControllerProviderInterface
{
    /** {@inheritdoc} */
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        /**
         * @SWG\Parameter(name="date", type="string", in="path")
         * @SWG\Tag(name="fuetterung", description="tägliche Fütterungen verwalten")
         */

        /**
         * @SWG\Get(
         *     path="/fuetterung",
         *     tags={"fuetterung"},
         *     @SWG\Response(response="200", description="Alle Fütterungen")
         * )
         */
        $controllers->get('', 'service.fuetterung:readAll');
        /**
         * @SWG\Get(
         *     path="/fuetterung/{date}",
         *     tags={"fuetterung"},
         *     @SWG\Parameter(ref="#/parameters/date"),
         *     @SWG\Response(
         *         response="200",
         *         description="Fütterung an dem gewählten Datum",
         *          @SWG\Schema(ref="#/definitions/fuetterung")
         *     )
         * )
         */
        $controllers->get('/{date}', 'service.fuetterung:read');
        /**
         * @SWG\Post(
         *     tags={"fuetterung"},
         *     path="/fuetterung",
         *     @SWG\Parameter(name="fuetterung", in="body", @SWG\Schema(ref="#/definitions/fuetterung")),
         *     @SWG\Response(
         *             response="201",
         *             description="neuer Fütterungseintrag"
         *     )
         * )
         */
        $controllers->post('', 'service.fuetterung:create');
        /**
         * @SWG\Put(
         *     tags={"fuetterung"},
         *     path="/fuetterung/{date}",
         *     @SWG\Parameter(ref="#/parameters/date"),
         *     @SWG\Response(
         *          response="200",
         *          description="geänderter Fütterungseintrag",
         *          @SWG\Schema(ref="#/definitions/fuetterung")
         *     )
         * )
         */
        $controllers->put('/{date}', 'service.fuetterung:update');
        return $controllers;
    }
}