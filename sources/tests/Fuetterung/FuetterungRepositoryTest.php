<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 14.05.16
 * Time: 23:10
 */

namespace TerraMonitoring\Web\Fuetterung;


use Doctrine\DBAL\Query\QueryBuilder;
use TerraMonitoring\Web\Entity\Fuetterung;

class FuetterungRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Doctrine\DBAL\Connection|\PHPUnit_Framework_MockObject_MockObject $db */
    private $db;
    /** @var  FuetterungRepository */
    private $repository;
    public function setUp()
    {
        $this->db = self::getMockBuilder('Doctrine\DBAL\Connection')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->repository = new FuetterungRepository($this->db);
    }
    /**
     * @test
     */
    public function shouldReturnTableName()
    {
        self::assertEquals('fuetterung', $this->repository->getTableName());
    }
    /**
     * @test
     */
    public function getOrderById()
    {
        $fuetterung = new Fuetterung('2016-05-15');
        $orders = [
            ['id' => 1, 'status' => 'placed'],
        ];
        $this->db->expects(self::once())
            ->method('from')
            ->with('fuetterung')
            ->willReturn($orders)
        ;
        self::assertEquals($fuetterung, $this->repository->getById(1));
    }
    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Order with id "1" not exists!
     */
    public function orderByIdNotFound()
    {
        $this->db->expects(self::once())
            ->method('fetchAll')
            ->willReturn([])
        ;
        $this->repository->getById(1);
    }
    /**
     * @test
     */
    public function getAllOrders()
    {
        $sql   = <<<EOS
SELECT o.* 
FROM `order` o
EOS;
        $order = new Order(1);
        $order->setStatus('placed');
        $orders = [
            ['id' => 1, 'status' => 'placed'],
        ];
        $this->db->expects(self::once())
            ->method('fetchAll')
            ->with($sql)
            ->willReturn($orders)
        ;
        $result = $this->repository->getAll();
        self::assertEquals($order, $result[0]);
    }
    /**
     * @test
     */
    public function insertAnOrder()
    {
        $orderData = ['status' => 'placed'];
        $this->db->expects(self::once())
            ->method('insert')
            ->with('order', $orderData)
        ;
        $this->db->expects(self::once())
            ->method('lastInsertId')
            ->willReturn(1)
        ;
        $order = new Order();
        $order->setStatus('placed');
        $this->repository->save($order);
        self::assertEquals(1, $order->getId());
    }
}