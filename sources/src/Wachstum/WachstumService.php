<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:16
 */

namespace TerraMonitoring\Web\Wachstum;


use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TerraMonitoring\Web\Entity\Wachstum;

class WachstumService
{
    /** @var WachstumRepository */
    private $wachstumRepository;

    /**
     * WachstumService constructor.
     *
     * @param WachstumRepository $wachstumRepository
     */
    public function __construct(WachstumRepository $wachstumRepository)
    {
        $this->wachstumRepository = $wachstumRepository;
    }


    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function readAll()
    {
        return new JsonResponse($this->wachstumRepository->getAll());
    }

    /**
     * @param date
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function read($date)
    {
        $byId = $this->wachstumRepository->getById($date);
        if (null === $byId) {
            return new Response("Not Found", 404);
        }

        return new JsonResponse($byId);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->request->all();
        $wachstum = Wachstum::create($data);
        $this->wachstumRepository->save($wachstum);
        return new JsonResponse($wachstum, 201);
    }

    /**
     * @param date
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update($date, Request $request)
    {
        if (null === $this->wachstumRepository->getById($date)) {
            throw new Exception('Wachstum not found', 404);
        }

        $data = $request->request->all();
        // Inject passed date
        $data['date'] = $date;
        $wachstum = Wachstum::create($data);
        $this->wachstumRepository->save($wachstum);
        return new JsonResponse($wachstum);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function max()
    {
        $max = $this->wachstumRepository->getMax();
        if (false === $max) {
            throw new Exception('No Max Wachstum found', 404);
        }

        return new JsonResponse($max);
    }

    /**
     * @param $from
     * @param $to
     * @return JsonResponse
     */
    public function getBetween($from, $to)
    {
        return new JsonResponse($this->wachstumRepository->getBetween($from, $to));
    }

}
