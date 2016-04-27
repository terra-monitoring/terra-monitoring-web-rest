<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 17:19
 */

namespace TerraMonitoring\Web;


use Doctrine\DBAL\Connection;

class DatabaseSetup
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
        $this->init();
    }

    private function init() {
        $this->db->exec('CREATE TABLE animal (id INTEGER PRIMARY KEY AUTOINCREMENT, name varchar(10))');
        $this->db->exec("INSERT INTO animal('name') VALUES ('fnord')");
    }

}



