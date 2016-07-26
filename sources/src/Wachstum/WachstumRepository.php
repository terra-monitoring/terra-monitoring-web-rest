<?php

namespace TerraMonitoring\Web\Wachstum;


use Doctrine\DBAL\Connection;
use PDO;
use Symfony\Component\Config\Definition\Exception\Exception;
use TerraMonitoring\Web\Entity\Wachstum;

class WachstumRepository
{

    /** @var  Connection */
    private $connection;

    /**
     * OrderRepository constructor.
     *
     * @param \Doctrine\DBAL\Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    function getTableName()
    {
        return 'wachstum';
    }

    /**
     * Get Wachstum by id.
     * @param $id
     * @return bool|\TerraMonitoring\Web\Entity\Wachstum returns Wachstum or false if not exists
     */
    function getById($id)
    {
        $data = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName())
            ->where('date = :date')
            ->setParameter(':date', $id)
            ->execute()
            ->fetch();

        if (false === $data) {
            return false;
        }

        return Wachstum::create($data);

    }

    /**
     * @return \TerraMonitoring\Web\Entity\Wachstum[]
     */
    function getAll()
    {
        $wachstumArray = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName())
            ->execute()
            ->fetchAll();

        $allWachstum = [];
        foreach ($wachstumArray as $row) {
            $allWachstum[] = Wachstum::create($row);
        }

        return $allWachstum;
    }

    /**
     * Get data between dates.
     * @param $from string
     * @param $to string
     * @return \TerraMonitoring\Web\Entity\Wachstum[]
     * @throws \Exception
     */
    function getBetween($from, $to)
    {
        $wachstumArray = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName())
            ->where("date BETWEEN '$from' AND '$to'")
            ->execute()
            ->fetchAll();

        if( false === $wachstumArray ) {
            throw new \Exception( "No data found in this time spawn." );
        }

        $allWachstum = [];
        foreach ($wachstumArray as $row) {
            $allWachstum[] = Wachstum::create($row);
        }

        return $allWachstum;
    }


    function save(Wachstum $object)
    {
        $wachstum_array = $object->jsonSerialize();

        $date = (array_key_exists('date', $wachstum_array)
            && !empty($wachstum_array['date'] ) ) ? $wachstum_array['date'] : null;
        if (null === $date) {
            throw new \Exception("Date of object is not present or invalid.");
        }

        // if no entry with this date it is a new entry
        $update_instead_insert_mode = (false === $this->getById($date)) ? false : true;
        if ($update_instead_insert_mode) {
            $this->update($wachstum_array);
        } else {
            $this->insert($wachstum_array);

        }
    }

    /**
     * Retrieve database type.
     * @param $key string key name.
     * @return int|null PDO::PARAM_* constant|null if not known.
     */
    public function getType($key)
    {
        switch ($key) {
            case "gewicht":
            case "laenge":
            case "date":
                $type = PDO::PARAM_STR;
                break;
            default:
                $type = null;
        }
        return $type;
    }

    private function update($wachstum_array)
    {
        $builder = $this->connection->createQueryBuilder()
            ->update($this->getTableName());
        $date = $wachstum_array['date'];

        // set attributes
        foreach ($wachstum_array as $param => $value) {
            $builder->set("$param", ":$param");
            $builder->setParameter(":$param", $value, $this->getType($param));
        }

        // set where and exec
        $builder->where('date = :date')
            ->setParameter(':date', $date, PDO::PARAM_STR);

        $builder->execute();
    }

    private function insert($wachstum_array)
    {
        $builder = $this->connection->createQueryBuilder()
            ->insert($this->getTableName());

        // set attributes
        foreach ($wachstum_array as $param => $value) {
            $builder->setValue("$param", ":$param");
            $builder->setParameter(":$param", $value, $this->getType($param));
        }

        $builder->execute();
    }

    /**
     * Returns the maximum Wachstum by Gewicht.
     * @return bool|Wachstum Wachstum, false if not found any data
     */
    public function getMax()
    {
        $builder = $this->connection
        ->createQueryBuilder()
        ->select("*")
        ->from($this->getTableName())
        ->orderBy("gewicht", "DESC")
        ->setMaxResults(1)
        ;

        $data = $builder->execute()->fetch();

        if( false === $data ) {
            return false;
        }

        return Wachstum::create($data);
    }
}