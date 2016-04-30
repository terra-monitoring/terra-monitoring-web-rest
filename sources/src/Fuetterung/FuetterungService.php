<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:16
 */

namespace TerraMonitoring\Web\Fuetterung;


use Doctrine\DBAL\Connection;
use TerraMonitoring\Web\Entity\Fuetterung;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FuetterungService
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function readAll()
    {
        $fuetterung = $this->db->fetchAll("SELECT * FROM fuetterung;");
        $fuetterung_coll = [];
        foreach ( $fuetterung as $row ) {
            $fuetterungObj = new Fuetterung($row['date']);
            $fuetterungObj->setFutterId($row['futter_id']);
            $fuetterungObj->setMenge($row['menge']);
            $fuetterungObj->setVitamin($row['vitamin']);
            $fuetterungObj->setCalcium($row['calcium']);
            $fuetterungObj->setFastentag($row['fastentag']);
            $fuetterungObj->setBemerkung($row['bemerkung']);
            $fuetterung_coll[] = $fuetterungObj;
        }

        return new JsonResponse($fuetterung_coll);
    }
    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDetails($date)
    {
        $row = $this->db->fetchAssoc("SELECT * FROM fuetterung WHERE date = $date;");

        //print_r($row);
            $fuetterungObj = new Fuetterung($row['date']);
            $fuetterungObj->setFutterId($row['futter_id']);
            $fuetterungObj->setMenge($row['menge']);
            $fuetterungObj->setVitamin($row['vitamin']);
            $fuetterungObj->setCalcium($row['calcium']);
            $fuetterungObj->setFastentag($row['fastentag']);
            $fuetterungObj->setBemerkung($row['bemerkung']);

        return new JsonResponse($fuetterungObj);
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
        return new JsonResponse(new Fuetterung($request->request->get('id', 0)),
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
        $animal = new Fuetterung($id);
        $animal->setName($newName);
        return new JsonResponse($animal);
    }
}