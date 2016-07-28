<?php
/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 28.07.16
 * Time: 14:28
 */

namespace TerraMonitoring\Web\Entity;

use Swagger\Annotations as SWG;

/**
 *
 * @SWG\Definition(definition="queryresponse",type="object")
 */
class QueryResponse implements \JsonSerializable
{
    /**
     * @var array|Fuetterung[]
     * @SWG\Property(type="array", items="#/definitions/fuetterung", ref="#/definitions/fuetterung")
     */
    private $fuetterungen = [];
    /**
     * @var array|Wachstum[]
     * @SWG\Property(type="array", items="#/definitions/wachstum", ref="#/definitions/wachstum")
     */
    private $wachstum = [];

    public function jsonSerialize()
    {
        return [
            'fuetterungen' => $this->fuetterungen,
            'wachstum' => $this->wachstum
        ];
    }

    /**
     * @param array $fuetterungen
     * @return QueryResponse
     */
    public function setFuetterungen($fuetterungen)
    {
        $this->fuetterungen = $fuetterungen;
        return $this;
    }

    /**
     * @return array
     */
    public function getFuetterungen()
    {
        return $this->fuetterungen;
    }

    /**
     * @param array $wachstum
     * @return QueryResponse
     */
    public function setWachstum($wachstum)
    {
        $this->wachstum = $wachstum;
        return $this;
    }

    /**
     * @return array
     */
    public function getWachstum()
    {
        return $this->wachstum;
    }
}