<?php

namespace TerraMonitoring\Web\Entity;

use Swagger\Annotations as SWG;

/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 17:01
 *
 * @SWG\Definition(definition="wachstum",type="object")
 */
class Wachstum implements \JsonSerializable
{
    /**
     * @var String
     * @SWG\Property(type="string")
     */
    private $date;
    /**
     * @var Integer
     * @SWG\Property(type="number", format="double")
     */
    private $gewicht;
    /**
     * @var Integer
     * @SWG\Property(type="number", format="double")
     */
    private $laenge;




    /**
     * Wachstum constructor.
     * @param date
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    public static function create(array $data) {
        $wachstumObj = new Wachstum($data['date']);
        $wachstumObj
            ->setGewicht($data['gewicht'])
            ->setLaenge($data['laenge']);
        return $wachstumObj;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $gewicht
     * @return $this Wachstum
     */
    public function setGewicht($gewicht)
    {
        $this->gewicht = $gewicht;
        return $this;
    }

    /**
     * @param mixed $laenge
     * @return $this Wachstum
     */
    public function setLaenge($laenge)
    {
        $this->laenge = $laenge;
        return $this;
    }
    

    public function jsonSerialize()
    {
        return [
            'date'     => $this->date,
            'gewicht' => $this->gewicht,
            'laenge' => $this->laenge,
            
        ];
    }
}