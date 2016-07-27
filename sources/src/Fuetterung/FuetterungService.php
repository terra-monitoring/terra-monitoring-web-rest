<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 20:16
 */

namespace TerraMonitoring\Web\Fuetterung;


use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TerraMonitoring\Web\Entity\Fuetterung;

class FuetterungService
{
    /** @var FuetterungRepository */
    private $fuetterungRepository;

    /**
     * FuetterungService constructor.
     *
     * @param FuetterungRepository $fuetterungRepository
     */
    public function __construct(FuetterungRepository $fuetterungRepository)
    {
        $this->fuetterungRepository = $fuetterungRepository;
    }


    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function readAll()
    {
        return new JsonResponse($this->fuetterungRepository->getAll());
    }

    /**
     * @param date
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function read($date)
    {
        $byId = $this->fuetterungRepository->getById($date);
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
        $fuetterung = Fuetterung::create($data);
        $this->fuetterungRepository->save($fuetterung);
        return new JsonResponse($fuetterung, 201);
    }

    /**
     * @param date
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update($date, Request $request)
    {
        if (false === $this->fuetterungRepository->getById($date)) {
            throw new Exception('Fuetterung not found', 404);
        }

        $data = $request->request->all();
        // Inject passed date
        $data['date'] = $date;
        $fuetterung = Fuetterung::create($data);
        $this->fuetterungRepository->save($fuetterung);
        return new JsonResponse($fuetterung);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function totalConsum(Request $request)
    {
        return new JsonResponse(
            $this->fuetterungRepository->totalConsum()
        );
    }

    /**
     * @param $from
     * @param $to
     * @return JsonResponse
     */
    public function getBetween($from, $to)
    {
        return new JsonResponse($this->fuetterungRepository->getBetween($from, $to));
    }
}
