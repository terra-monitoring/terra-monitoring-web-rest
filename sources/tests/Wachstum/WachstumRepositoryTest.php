<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 14.05.16
 * Time: 23:10
 */

namespace TerraMonitoring\Web\Wachstum;



use TerraMonitoring\Web\Entity\Wachstum;

class WachstumRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Doctrine\DBAL\Connection|\PHPUnit_Framework_MockObject_MockObject $db */
    private $db;
    /** @var  WachstumRepository */
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

        $this->repository = new WachstumRepository($this->db);
    }
    /**
     * @test
     */
    public function shouldReturnTableName()
    {
        self::assertEquals('wachstum', $this->repository->getTableName());
    }
    /**
     * @test
     */
    public function getById()
    {
        $date = '2016-05-15';
        $attributes = [
            'date' => $date,
            'gewicht' => 6,
            'laenge' => 7
        ];
        $wachstum = Wachstum::create($attributes);
        $wachstums = [
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
            ->with('wachstum')
            ->willReturn($this->mockQueryBuilder);
         $this->mockQueryBuilder->expects(self::once())
             ->method('where')
             ->with('date = :date')
             ->willReturn($this->mockQueryBuilder);
        $this->mockQueryBuilder->expects(self::once())
            ->method('setParameter')
            ->with(':date', $date)
            ->willReturn($this->mockQueryBuilder);
        $this->mockQueryBuilder->expects(self::once())
            ->method('execute')
            ->willReturn($statmentMock);
        $statmentMock->expects(self::once())
            ->method('fetch')
            ->willReturn($wachstums[0]);

        $actually = $this->repository->getById($date);
        self::assertEquals($wachstum, $actually);
    }
    /**
     * @test
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
            ->with('wachstum')
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

        $result = $this->repository->getById('2016-05-15');
        $this->assertFalse($result, "The object should not be found and the method should return false.");
    }
    /**
     * @test
     */
    public function getAllOrders()
    {
        $wachtum = [
            Wachstum::create(
                [
                    'date' => '2016-05-23',
                    'gewicht' => 7,
                    'laenge' => 8
                ]
            )->jsonSerialize()
            ,
            Wachstum::create(
                [
                    'date' => '2016-05-27',
                    'gewicht' => 7,
                    'laenge' => 8
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
            ->with('wachstum')
            ->willReturn($this->mockQueryBuilder);
        $this->mockQueryBuilder->expects(self::once())
            ->method('execute')
            ->willReturn($statmentMock);
        $statmentMock->expects(self::once())
            ->method('fetchAll')
            ->willReturn($wachtum);
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
        $empty_primary_key_is_invalid = "";
        $wachstum = new Wachstum($empty_primary_key_is_invalid);
        $this->repository->save($wachstum);
    }
    
}