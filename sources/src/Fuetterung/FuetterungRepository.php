<?php

namespace TerraMonitoring\Web\Fuetterung;


use Doctrine\DBAL\Connection;
use ocramius\util\Optional;
use PDO;
use Symfony\Component\Config\Definition\Exception\Exception;
use TerraMonitoring\Web\Entity\Fuetterung;

class FuetterungRepository
{

    /** @var Connection */
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
        return 'fuetterung';
    }

    /**
     * Get Fuetterung by id.
     * @param $id
     * @return bool|\TerraMonitoring\Web\Entity\Fuetterung returns Fuetterung or false if not exists
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

        return Fuetterung::create($data);
    }

    /**
     * @return \TerraMonitoring\Web\Entity\Fuetterung[]
     */
    function getAll()
    {
        $fuetterungen = $this->connection->createQueryBuilder()
            ->select("*")
            ->from($this->getTableName())
            ->execute()
            ->fetchAll();

        $allFuetterungen = [];
        foreach ($fuetterungen as $row) {
            $allFuetterungen[] = Fuetterung::create($row);
        }

        return $allFuetterungen;
    }

    function save(Fuetterung $object)
    {
        $fuetterung_array = $object->jsonSerialize();

        $date = (array_key_exists('date', $fuetterung_array)
            && !empty($fuetterung_array['date'] ) ) ? $fuetterung_array['date'] : null;
        if (null === $date) {
            throw new \Exception("Date of object is not present or invalid.");
        }

        // if no entry with this date exists it is a new entry
        $update_instead_insert_mode = (false === $this->getById($date)) ? false : true;
        if ($update_instead_insert_mode) {
            $this->update($fuetterung_array);
        } else {
            $this->insert($fuetterung_array);
        }
    }

    /**
     * Retrieve database type.
     * @param $key string key name.
     * @return int|null PDO::PARAM_* constant|null if not known.
     */
    private function getType($key)
    {
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
                $type = null;
        }
        return $type;
    }

    private function update($fuetterung_array)
    {
        $builder = $this->connection->createQueryBuilder()
            ->update($this->getTableName());
        $date = $fuetterung_array['date'];

        // set attributes
        foreach ($fuetterung_array as $param => $value) {
            $builder->set("$param", ":$param");
            $builder->setParameter(":$param", $value, $this->getType($param));
        }

        // set where and exec
        $builder->where('date = :date')
            ->setParameter(':date', $date, PDO::PARAM_STR);

        $builder->execute();
    }

    private function insert($fuetterung_array)
    {
        $builder = $this->connection->createQueryBuilder()
            ->insert($this->getTableName());

        // set attributes
        foreach ($fuetterung_array as $param => $value) {
            $builder->setValue("$param", ":$param");
            $builder->setParameter(":$param", $value, $this->getType($param));
        }

        $builder->execute();
    }

    public function totalConsum() {
        $builder = $this->connection
            ->createQueryBuilder()
            ->select("*")
            ->from("futter")
        ;

        $futter_array = $builder->execute()->fetchAll();

        if( false === $futter_array ) {
            throw new \Exception("No Futter in database.");
        }

        $futter_mengen = [];
        foreach ($futter_array as $futter) {
            $builder = $this->connection
                ->createQueryBuilder()
                ->select("sum(menge)")
                ->from("fuetterung")
                ->where("futter_id = " . $futter['id'])
            ;
            $menge = $builder->execute()->fetch(PDO::FETCH_NUM);
            if( false !== $menge ) {
                $futter_mengen[$futter["name"]] = $menge[0];
            }
        }

        return $futter_mengen;
    }
}