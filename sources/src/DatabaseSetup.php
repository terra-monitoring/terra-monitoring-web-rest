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
use Symfony\Component\Finder\Finder;

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
        $finder = new Finder();
        $finder->in(__DIR__);
        $finder->name('schema.sql');

        foreach ($finder as $file) {
            $content = $file->getContents();

            try {
                $this->db->exec($content);
            } catch (DBALException $dbale) {
                // exception occurs because tables already exist. No mechanism to detect yet
            }
        }
    }
}



