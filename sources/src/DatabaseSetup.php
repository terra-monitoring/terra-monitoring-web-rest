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

    private function init()
    {
        $this->db->exec('CREATE TABLE futter (id INTEGER PRIMARY KEY AUTOINCREMENT, name STRING)');
        $this->db->exec("INSERT INTO futter('name') VALUES ('Kleine Heimchen')");
        $this->db->exec("INSERT INTO futter('name') VALUES ('Mittlere Heimchen')");
        $this->db->exec("INSERT INTO futter('name') VALUES ('Große Heimchen')");
        $this->db->exec("INSERT INTO futter('name') VALUES ('Kleine Steppengrillen')");


        $this->db->exec('CREATE TABLE fuetterung (date DATE PRIMARY KEY, futter_id INTEGER, menge INTEGER, vitamin BOOLEAN, calcium BOOLEAN, fastentag BOOLEAN, bemerkung STRING)');

        $this->db->exec('CREATE TABLE wachstum (date DATE PRIMARY KEY, gewicht INTEGER, laenge INTEGER)');
    }
}



