<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:13
 */

namespace TerraMonitoring\Web\Animal;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Swagger\Annotations as SWG;

class AnimalRoutesProvider implements ControllerProviderInterface
{
    /** {@inheritdoc} */
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        /**
         * @SWG\Parameter(name="id", type="integer", format="int32", in="path")
         * @SWG\Tag(name="animal", description="All animals")
         */
        /**
         * @SWG\Get(
         *     path="/animal",
         *     tags={"animal"},
         *     @SWG\Response(response="200", description="An example resource")
         * )
         */
        $controllers->get('', 'service.animal:getList');
        /**
         * @SWG\Get(
         *     path="/animal/{id}",
         *     tags={"animal"},
         *     @SWG\Parameter(ref="#/parameters/id"),
         *     @SWG\Response(
         *         response="200",
         *         description="An example resource",
         *          @SWG\Schema(ref="#/definitions/animal")
         *     )
         * )
         */
        $controllers->get('/{animalId}', 'service.animal:getDetails');
        /**
         * @SWG\Post(
         *     tags={"animal"},
         *     path="/animal",
         *     @SWG\Parameter(name="animal", in="body", @SWG\Schema(ref="#/definitions/animal")),
         *     @SWG\Response(response="201", description="An example resource")
         * )
         */
        $controllers->post('', 'service.animal:createAnimal');
        /**
         * @SWG\Put(
         *     tags={"animal"},
         *     path="/animal/{id}",
         *     @SWG\Parameter(ref="#/parameters/id"),
         *     @SWG\Response(
         *          response="200",
         *          description="An example resource",
         *          @SWG\Schema(ref="#/definitions/animal")
         *     )
         * )
         */
        $controllers->put('/{animalId}', 'service.animal:changeAnimal');
        return $controllers;
    }
}