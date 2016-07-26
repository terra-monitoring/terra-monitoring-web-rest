<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:13
 */

namespace TerraMonitoring\Web\Wachstum;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Swagger\Annotations as SWG;

class WachstumRoutesProvider implements ControllerProviderInterface
{
    /** {@inheritdoc} */
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        /**
         * 
         * @SWG\Tag(name="wachstum", description="wachstums daten")
         *
         */

        /**
         * @SWG\Get(
         *     path="/wachstum/",
         *     tags={"wachstum"},
         *     @SWG\Response(response="200", description="Alle Wachstumsdaten")
         * )
         */
        $controllers->get('/', 'service.wachstum:readAll');

        /**
         * @SWG\Get(
         *     path="/wachstum/{from}/{to}",
         *     tags={"wachstum"},
         *     @SWG\Parameter(
         *          name="from",
         *          in="path",
         *          description="Date from",
         *          required=true,
         *          type="string"
         *   ),
         *   @SWG\Parameter(
         *           name="to",
         *          in="path",
         *          description="Date to",
         *          required=true,
         *          type="string"
         *   ),
         *     @SWG\Response(
         *         response="200",
         *         description="Collection von Wachstum im Zeitraum",
         *          @SWG\Schema(ref="#/definitions/wachstum")
         *     )
         * )
         */
        $controllers->get('/{from}/{to}', 'service.wachstum:getBetween');
        /**
         * @SWG\Get(
         *     path="/wachstum/{date}",
         *     tags={"wachstum"},
         *     @SWG\Parameter(ref="#/parameters/date"),
         *     @SWG\Response(
         *         response="200",
         *         description="Wachstum an dem gewählten Datum",
         *          @SWG\Schema(ref="#/definitions/wachstum")
         *     )
         * )
         */
        $controllers->get('/{date}', 'service.wachstum:read');
        /**
         * @SWG\Post(
         *     tags={"wachstum"},
         *     path="/wachstum/",
         *     @SWG\Parameter(name="wachstum", in="body", @SWG\Schema(ref="#/definitions/wachstum")),
         *     @SWG\Response(
         *         response="201",
         *         description="neuer Wachstumseintrag"
         *     )
         * ))
         */
        $controllers->post('/', 'service.wachstum:create');

        /**
         * @SWG\Put(
         *     tags={"wachstum"},
         *     path="/wachstum/{date}",
         *     @SWG\Parameter(
         *         name="date",
         *         in="path",
         *         description="Datensatz für das gewählte Datum welcher geändert werden soll",
         *         required=true,
         *         type="string"
         *     ),
         *     @SWG\Parameter(
         *         name="body",
         *         in="body",
         *         description="neue Daten",
         *         required=false,
         *         @SWG\Schema(ref="#/definitions/wachstum")
         *     ),
         *     @SWG\Schema(ref="#/definitions/wachstum"),
         *     @SWG\Response(
         *         response="200",
         *         description="geänderter Wachstumseintrag",
         *         @SWG\Schema(ref="#/definitions/wachstum")
         *     ),
         *     @SWG\Response(response=404, description="Wachstum not found")
         * )
         */
        $controllers->put('/{date}', 'service.wachstum:update');

        /**
         * @SWG\Get(
         *     path="/wachstum/gewicht/max",
         *     tags={"wachstum"},
         *     @SWG\Schema(ref="#/definitions/wachstum"),
         *     @SWG\Response(
         *         response="200",
         *         description="Maximum des Gewichts",
         *         @SWG\Schema(ref="#/definitions/wachstum")
         *     )
         * )
         */
        $controllers->get('/gewicht/max', 'service.wachstum:max');
        return $controllers;
    }
}
