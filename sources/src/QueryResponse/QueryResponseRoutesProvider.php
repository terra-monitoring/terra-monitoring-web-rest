<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:13
 */

namespace TerraMonitoring\Web\QueryResponse;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Swagger\Annotations as SWG;

class QueryResponseRoutesProvider implements ControllerProviderInterface
{
    /** {@inheritdoc} */
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        /**
         *
         * @SWG\Tag(name="queryResponse", description="Statistiken abrufen")
         *
         */

        /**
         * @SWG\Get(
         *     path="/queryResponse/{from}/{to}",
         *     tags={"queryResponse"},
         *     summary="alle Daten im Zeitraum",
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
         *         description="alle Daten im Zeitraum",
         *         @SWG\Schema(
         *             type="array",
         *             @SWG\Items(ref="#/definitions/queryresponse")
         *         )
         *     )
         * )
         */
        $controllers->get('/{from}/{to}', 'service.queryResponse:getBetween');

        return $controllers;
    }
}
