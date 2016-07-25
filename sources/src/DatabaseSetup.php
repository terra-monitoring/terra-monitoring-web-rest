<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 17:19
 */

namespace TerraMonitoring\Web;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

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
        $this->db->exec("INSERT INTO futter('name') VALUES ('Heimchen (micro)')");
        $this->db->exec("INSERT INTO futter('name') VALUES ('Heimchen (klein)')");
        $this->db->exec("INSERT INTO futter('name') VALUES ('Heimchen (subadult)')");
        $this->db->exec("INSERT INTO futter('name') VALUES ('Steppengrillen (klein)')");
        $this->db->exec("INSERT INTO futter('name') VALUES ('Wüstenheuschrecken (klein)')");
        $this->db->exec("INSERT INTO futter('name') VALUES ('Wüstenheuschrecken (mittel)')");

        $this->db->exec('CREATE TABLE fuetterung (date DATE PRIMARY KEY, futter_id INTEGER, menge INTEGER, vitamin BOOLEAN, calcium BOOLEAN, fastentag BOOLEAN, bemerkung STRING)');
        $this->db->exec("INSERT INTO fuetterung values('2016-02-14',null,0,'false','false','false','Übergangsterrarium')");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-15',1,10,'true','false','false','Übergangsterrarium');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-16',1,3,'false','false','false','Übergangsterrarium');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-17',1,4,'false','false','false','Übergangsterrarium');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-18',null,0,'false','false','false','Übergangsterrarium');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-19',1,12,'false','false','false','Übergangsterrarium');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-20',null,0,'false','false','false','Übergangsterrarium');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-21',1,9,'false','false','false','Übergangsterrarium');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-22',1,1,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-23',1,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-24',1,7,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-25',1,8,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-26',1,8,'false','false','false','ab jetzt 70W UV-Lampe');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-27',1,8,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-28',1,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-02-29',1,9,'false','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-01',1,7,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-02',1,7,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-03',1,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-04',1,13,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-05',1,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-06',1,6,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-07',1,6,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-08',1,11,'false','false','false','seit heute wassergel für Futtertiere');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-09',1,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-10',1,11,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-11',1,10,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-12',1,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-13',1,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-14',1,8,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-15',1,11,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-16',1,7,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-17',1,9,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-18',1,7,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-19',2,8,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-20',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-21',2,2,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-22',2,6,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-23',2,9,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-24',2,8,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-25',2,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-26',2,8,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-27',2,9,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-28',2,9,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-29',2,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-30',2,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-03-31',2,13,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-01',2,12,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-02',2,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-03',2,10,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-04',2,8,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-05',4,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-06',2,9,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-07',4,2,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-08',2,8,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-09',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-10',2,11,'true','true','false','Häutung');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-11',2,8,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-12',4,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-13',2,7,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-14',2,7,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-15',2,9,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-16',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-17',2,7,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-18',null,0,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-19',2,11,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-20',2,9,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-21',2,11,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-22',2,10,'false','false','false','neue Zeit: 07:00-20:00');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-23',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-24',2,9,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-25',4,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-26',null,0,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-27',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-28',2,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-29',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-04-30',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-01',2,4,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-02',2,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-03',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-04',2,6,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-05',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-06',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-07',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-08',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-09',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-10',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-11',5,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-12',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-13',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-14',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-15',5,4,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-16',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-17',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-18',5,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-19',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-20',5,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-21',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-22',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-23',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-24',4,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-25',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-26',4,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-27',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-28',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-29',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-30',5,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-05-31',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-01',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-02',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-03',2,9,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-04',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-05',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-06',2,8,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-07',2,4,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-08',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-09',2,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-10',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-11',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-12',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-13',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-14',6,1,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-15',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-16',6,1,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-17',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-18',null,null,'null','null','true','Häutung / neue Zeit 07:00 - 21:00');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-19',6,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-20',2,6,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-21',2,6,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-22',6,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-23',2,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-24',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-25',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-26',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-27',5,4,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-28',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-29',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-06-30',5,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-01',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-02',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-03',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-04',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-05',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-06',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-07',2,6,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-08',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-09',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-10',2,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-11',2,5,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-12',2,6,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-13',6,3,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-14',3,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-15',3,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-16',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-17',3,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-18',3,5,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-19',3,2,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-20',6,2,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-21',3,4,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-22',null,null,'null','null','true','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-23',6,2,'false','false','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-24',3,4,'true','true','false','');");
        $this->db->exec("INSERT INTO fuetterung values('2016-07-25',6,4,'false','false','false','');");

        $this->db->exec('CREATE TABLE wachstum (date DATE PRIMARY KEY, gewicht INTEGER, laenge INTEGER)');
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-07-18', 11.5, 22)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-07-11', 11.5, 19)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-07-05', 10, 18)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-06-27', 10, 16)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-06-19', 10, 14)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-06-13', 9, 14)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-06-07', 9, 9)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-05-30', 8, 7)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-05-22', 8, 9)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-05-15', 7.5, 6)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-05-09', 7, 6)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-05-02', 7, 5)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-04-24', 7, 5)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-04-17', 6.5, 5)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-04-11', 6, 5)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-04-04', 5.7, 3)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-03-25', 5, 2)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-03-18', 5, 2)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-03-12', 5, 2)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-03-05', 5, 2)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-02-24', 5, 1)");
        $this->db->exec("INSERT INTO wachstum (date, laenge, gewicht) VALUES ('2016-02-16', 5, 1)");
    }
}



