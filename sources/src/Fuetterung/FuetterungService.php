<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:16
 */

namespace TerraMonitoring\Web\Fuetterung;


use Doctrine\DBAL\Connection;
use PDO;
use Silex\Application;
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
            $allFuetterungen[] = Fuetterung::create($row);
        }

        return new JsonResponse($allFuetterungen);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function read($date)
    {
        $data = $this->db->createQueryBuilder()
            ->select("*")
            ->from("fuetterung")
            ->where('date = ?')
            ->setParameter(0, $date)
            ->execute()
            ->fetch();

        if(null === $data) {
            return new Response("Not Found", 404);
        }

        return new JsonResponse( Fuetterung::create($data) );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->request->all();
        $this->db->insert("fuetterung", $data);
        return new JsonResponse( Fuetterung::create($data) , 201);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update($date, Request $request)
    {
        $data = $request->request->all();
        $fuetterung = Fuetterung::create($data);

        $array = A::create($fuetterung->jsonSerialize());
        if($array->containsKey('date') ) {
            unset($array['date']);
        }

        // create builder
        $builder = $this->db->createQueryBuilder()
            ->update('fuetterung')
        ;
        // set attributes
        foreach ( $array as $param => $value ) {
            $builder->set("$param", ":$param");
            $builder->setParameter(":$param", $value, $this->getType($param));
        }

        // set where and exec
        $builder->where('date = :date')
            ->setParameter(':date', $date, PDO::PARAM_STR)
            ->execute()
        ;

        return new JsonResponse($fuetterung);
    }

    private function getType($key)
    {
        $type = null;
        switch ($key) {
            case "vitamin":
            case "calcium":
            case "fastentag":
                $type = PDO::PARAM_BOOL;
                break;
            case "date":
            case "bemerkung":
                $type = PDO::PARAM_STR;
                break;
            case "futter_id":
                $type = PDO::PARAM_INT;
                break;
            default:
        }
        return $type;
    }

}
