<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 06.04.16
 * Time: 17:37
 */
namespace TerraMonitoring\Web;
use Symfony\Component\HttpFoundation\Request;
class Util
{
    /**
     * Returns whether passed request is a JSON request.
     * @param Request $request
     * @return bool
     */
    public static function requestIsJson(Request $request)
    {
        return 0 === strpos(
            $request->headers->get('Content-Type'),
            'application/json'
        );
    }
}