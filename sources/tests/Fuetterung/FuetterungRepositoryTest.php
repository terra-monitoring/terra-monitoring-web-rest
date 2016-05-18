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
    private $mockQueryBuilder;

    public function setUp()
    {
        $this->db = self::getMockBuilder('Doctrine\DBAL\Connection')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->mockQueryBuilder = self::getMockBuilder('Doctrine\DBAL\Query\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $this->db->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($this->mockQueryBuilder);

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
        $date = '2016-05-15';
        $attributes = [
            'date' => $date,
            'futter_id' => 2,
            'menge' => '50',
            'vitamin' => false,
            'calcium' => true,
            'fastentag' => false,
            'bemerkung' => 'gut'
        ];
        $fuetterung = Fuetterung::create($attributes);
        $fuetterungen = [
            $attributes
        ];
        $statmentMock = self::getMockBuilder('Doctrine\DBAL\Driver\Statement')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->mockQueryBuilder->expects(self::once())
            ->method('select')
            ->with('*')
            ->willReturn($this->mockQueryBuilder);
        $this->mockQueryBuilder->expects(self::once())
            ->method('from')
            ->with('fuetterung')
            ->willReturn($this->mockQueryBuilder);
         $this->mockQueryBuilder->expects(self::once())
             ->method('where')
             ->with('date = :date')
             ->willReturn($this->mockQueryBuilder);
        $this->mockQueryBuilder->expects(self::once())
            ->method('setParameter')
            ->with(':date', '2016-05-15')
            ->willReturn($this->mockQueryBuilder);
        $this->mockQueryBuilder->expects(self::once())
            ->method('execute')
            ->willReturn($statmentMock);
        $statmentMock->expects(self::once())
            ->method('fetch')
            ->willReturn($fuetterungen[0]);

        $actually = $this->repository->getById($date);
        self::assertEquals($fuetterung, $actually);
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