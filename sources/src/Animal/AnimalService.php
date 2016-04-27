<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:16
 */

namespace TerraMonitoring\Web\Animal;


use Doctrine\DBAL\Connection;
use TerraMonitoring\Web\Entity\Animal;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AnimalService
{
    /**
     * The connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param $db \Doctrine\DBAL\Connection
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * GET /animal
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getList()
    {
        $animals = $this->db->fetchAll("SELECT * FROM animal;");
        $animals_coll = [];
        foreach ( $animals as $animal ) {
            $animalObj = new Animal($animal['id']);
            $animalObj->setName($animal['name']);
        }

        return new JsonResponse($animals_coll);
    }
    /**
     * GET /animal/{animalId}
     *
     * @param $animalId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDetails($animalId)
    {
        return new JsonResponse(new Animal($animalId));
    }
    /**
     * POST /animal
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAnimal(Request $request)
    {
        return new JsonResponse(new Animal($request->request->get('id', 0)),
            201);
    }
    /**
     * PUT /animal/{animalId}
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function changeAnimal(Request $request)
    {
        $id = $request->request->get('id', 0);
        $newName = $request->request->get('name', "");
        $animal = new Animal($id);
        $animal->setName($newName);
        return new JsonResponse($animal);
    }
}