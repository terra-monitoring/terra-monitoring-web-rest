<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:16
 */

namespace TerraMonitoring\Web\Fuetterung;


use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TerraMonitoring\Web\Entity\Fuetterung;
use Arrayzy\ArrayImitator as A;

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
        $fuetterungen = $this->db->createQueryBuilder()
            ->select("*")
            ->from("fuetterung")
            ->execute()
            ->fetchAll();

        $allFuetterungen = [];
        foreach ( $fuetterungen as $row ) {
            $allFuetterungen[] = $this->mapToObject($row);
        }

        return new JsonResponse($allFuetterungen);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function read($date)
    {
        $fuetterung = $this->db->createQueryBuilder()
            ->select("*")
            ->from("fuetterung")
            ->where('date = ?')
            ->setParameter(0, $date)
            ->execute()
            ->fetch();

        if(null === $fuetterung) {
            return new Response("Not Found", 404);
        }

        return new JsonResponse( $this->mapToObject( $fuetterung ) );
    }

    /**
     * POST /animal
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->request->all();
        $this->db->insert("fuetterung", $data);

        return new JsonResponse( $this->mapToObject(data) , 201);
    }

    /**
     * PUT /animal/{animalId}
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function change(Request $request)
    {
        $id = $request->request->get('id', 0);
        $newName = $request->request->get('name', "");
        $animal = new Fuetterung($id);
        $animal->setName($newName);
        return new JsonResponse($animal);
    }

    private function mapToObject(array $result)
     {

         $fuetterungObj = new Fuetterung($result['date']);
         $fuetterungObj
             ->setFutterId($result['futter_id'])
             ->setMenge($result['menge'])
             ->setVitamin($result['vitamin'])
             ->setCalcium($result['calcium'])
             ->setFastentag($result['fastentag'])
             ->setBemerkung($result['bemerkung']);
         return $fuetterungObj;
    }
}
