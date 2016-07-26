<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 26.07.16
 * Time: 13:53
 */

namespace TerraMonitoring\Web\Error;


use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
class DatabaseException extends \Exception implements HttpExceptionInterface
{
    public function __construct($message)
    {
        parent::__construct($message, ApiErrorCode::DATABASE_ERROR);
    }
    /** {@inheritdoc} */
    public function getStatusCode()
    {
        return Response::HTTP_NOT_FOUND;
    }
    /** {@inheritdoc} */
    public function getHeaders()
    {
        return [];
    }
}