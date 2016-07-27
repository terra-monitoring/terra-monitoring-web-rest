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
         *     path="/fuetterung/totalConsum",
         *     tags={"fuetterung"},
         *     summary="Futterverbrauch bestimmen",
         *     @SWG\Response(response="200", description="Bisheriger Futterverbrauch")
         * )
         */
        $controllers->get('/totalConsum', 'service.fuetterung:totalConsum');

        /**
         * @SWG\Get(
         *     path="/fuetterung/",
         *     tags={"fuetterung"},
         *     summary="Alle Fütterungen",
         *     @SWG\Response(
         *         response=200,
         *         description="Alle Fütterungen",
         *         @SWG\Schema(
         *             type="array",
         *             @SWG\Items(ref="#/definitions/fuetterung")
         *         )
         *     )
         * )
         */
        $controllers->get('/', 'service.fuetterung:readAll');

        /**
         * @SWG\Get(
         *     path="/fuetterung/{from}/{to}",
         *     tags={"fuetterung"},
         *     summary="Fütterungen im Zeitraum",
         *     @SWG\Parameter(
         *          name="from",
         *          in="path",
         *          description="Date from",
         *          required=true,
         *          type="string"
         *   ),
         *   @SWG\Parameter(
         *          name="to",
         *          in="path",
         *          description="Date to",
         *          required=true,
         *          type="string"
         *   ),
         *     @SWG\Response(
         *         response=200,
         *         description="Fuetterungen im Zeitraum",
         *         @SWG\Schema(
         *             type="array",
         *             @SWG\Items(ref="#/definitions/fuetterung")
         *         )
         *     )
         * )
         */
        $controllers->get('/{from}/{to}', 'service.fuetterung:getBetween');

        /**
         * @SWG\Get(
         *     path="/fuetterung/{date}",
         *     tags={"fuetterung"},
         *     summary="Fütterung an dem gewählten Datum",
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
         *     path="/fuetterung/",
         *     summary="Fütterung erstellen",
         *     @SWG\Parameter(name="fuetterung", in="body", @SWG\Schema(ref="#/definitions/fuetterung")),
         *     @SWG\Response(
         *         response="201",
         *         description="neue Fütterung"
         *     )
         * ))
         */
        $controllers->post('/', 'service.fuetterung:create');

        /**
         * @SWG\Put(
         *     tags={"fuetterung"},
         *     path="/fuetterung/{date}",
         *     summary="Fütterung ändern",
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
         *         @SWG\Schema(ref="#/definitions/fuetterung")
         *     ),
         *     @SWG\Schema(ref="#/definitions/fuetterung"),
         *     @SWG\Response(
         *         response="200",
         *         description="geänderte Fütterung",
         *         @SWG\Schema(ref="#/definitions/fuetterung")
         *     ),
         *     @SWG\Response(response=404, description="Fuetterung not found")
         * )
         */
        $controllers->put('/{date}', 'service.fuetterung:update');

        return $controllers;
    }
}
