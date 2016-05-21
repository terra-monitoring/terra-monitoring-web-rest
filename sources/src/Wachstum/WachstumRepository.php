<?php

namespace TerraMonitoring\Web\Wachstum;


use Doctrine\DBAL\Connection;
use PDO;
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
            return null;
        }

        return Wachstum::create($data);

    }

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

    function save(Wachstum $object)
    {
        $wachstum_array = $object->jsonSerialize();

        $date = (array_key_exists('date', $wachstum_array)
            && !empty($fuetterung_array['date'] ) ) ? $wachstum_array['date'] : null;
        if (null === $date) {
            throw new \Exception("Date of object is not present or invalid.");
        }

        // if no entry with this date it is a new entry
        $update_instead_insert_mode = (null === $this->getById($date)) ? false : true;
        if ($update_instead_insert_mode) {
            $this->update($wachstum_array);
        } else {
            $this->insert($wachstum_array);

        }
    }

    /**
     * Retrieve database type.
     * @param $key key name.
     * @return int|null PDO::PARAM_* constant|null if not known.
     */
    private function getType($key)
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
            ->update($this->getTableName());;
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
}