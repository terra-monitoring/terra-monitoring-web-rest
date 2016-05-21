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
    /** @var \Doctrine\DBAL\Query\QueryBuilder|\PHPUnit_Framework_MockObject_MockObject $db */
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

        $this->db
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
    public function getById()
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
     * @expectedExceptionMessage Fuetterung with id "2016-05-15" does not exist!
     */
    public function getByIdNotFound()
    {
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
            ->willReturn(false);

        $this->repository->getById('2016-05-15');
    }
    /**
     * @test
     */
    public function getAllOrders()
    {
        $fuetterungen = [
            Fuetterung::create(
                [
                    'date' => '2016-05-23',
                    'futter_id' => 2,
                    'menge' => '50',
                    'vitamin' => false,
                    'calcium' => true,
                    'fastentag' => false,
                    'bemerkung' => 'gut'
                ]
            )->jsonSerialize()
            ,
            Fuetterung::create(
                [
                    'date' => '2016-05-27',
                    'futter_id' => 2,
                    'menge' => '50',
                    'vitamin' => false,
                    'calcium' => true,
                    'fastentag' => false,
                    'bemerkung' => 'gut'
                ]
            )->jsonSerialize()
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
            ->method('execute')
            ->willReturn($statmentMock);
        $statmentMock->expects(self::once())
            ->method('fetchAll')
            ->willReturn($fuetterungen);
        ;
        $result = $this->repository->getAll();
        self::assertEquals('2016-05-23', $result[0]->getDate());
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Date of object is not present or invalid.
     */
    public function saveWithOutPrimaryKeyFails() {
        $fuetterung = new Fuetterung("");
        $this->repository->save($fuetterung);
    }
}