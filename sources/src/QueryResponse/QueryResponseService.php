<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:16
 */

namespace TerraMonitoring\Web\QueryResponse;


use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TerraMonitoring\Web\Entity\QueryResponse;
use TerraMonitoring\Web\Fuetterung\FuetterungRepository;
use TerraMonitoring\Web\Wachstum\WachstumRepository;

class QueryResponseService
{
    /**
     * @var WachstumRepository
     */
    private $wachstumRepository;
    /**
     * @var FuetterungRepository
     */
    private $fuetterungRepository;

    /**
     * QueryResponseService constructor.
     * @param WachstumRepository $wachstumRepository
     * @param FuetterungRepository $fuetterungRepository
     */
    public function __construct(WachstumRepository $wachstumRepository, FuetterungRepository $fuetterungRepository)
    {
        $this->wachstumRepository = $wachstumRepository;
        $this->fuetterungRepository = $fuetterungRepository;
    }

    /**
     * Get data in time spawn.
     * @param $from
     * @param $to
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getBetween($from, $to)
    {
        $queryResponse = new QueryResponse();
        $queryResponse->setFuetterungen( $this->fuetterungRepository->getBetween($from, $to) );
        $queryResponse->setWachstum( $this->wachstumRepository->getBetween($from, $to) );
        return new JsonResponse($queryResponse);
    }
}
