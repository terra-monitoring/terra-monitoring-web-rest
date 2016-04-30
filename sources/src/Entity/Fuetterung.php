<?php

namespace TerraMonitoring\Web\Entity;

/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 17:01
 */
class Fuetterung implements \JsonSerializable
{
    private $date;
    private $name;
    private $futter_id;
    private $menge;
    private $vitamin;
    private $calcium;
    private $fastentag;
    private $bemerkung;

    /**
     * Fuetterung constructor.
     * @param date
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $futter_id
     * @return $this Fuetterung
     */
    public function setFutterId($futter_id)
    {
        $this->futter_id = $futter_id;
        return $this;
    }

    /**
     * @param mixed $menge
     * @return $this Fuetterung
     */
    public function setMenge($menge)
    {
        $this->menge = $menge;
        return $this;
    }

    /**
     * @param mixed $vitamin
     * @return $this Fuetterung
     */
    public function setVitamin($vitamin)
    {
        $this->vitamin = $vitamin;
        return $this;
    }

    /**
     * @param mixed $calcium
     * @return $this Fuetterung
     */
    public function setCalcium($calcium)
    {
        $this->calcium = $calcium;
        return $this;
    }

    /**
     * @param mixed $fastentag
     * @return $this Fuetterung
     */
    public function setFastentag($fastentag)
    {
        $this->fastentag = $fastentag;
        return $this;
    }

    /**
     * @param mixed $bemerkung
     * @return $this Fuetterung
     */
    public function setBemerkung($bemerkung)
    {
        $this->bemerkung = $bemerkung;
        return $this;
    }



    public function jsonSerialize()
    {
        return [
            'date'     => $this->date,
            'futter_id' => $this->futter_id,
            'menge' => $this->menge,
            'vitamin' => $this->vitamin,
            'calcium' => $this->calcium,
            'fastentag' => $this->fastentag,
            'bemerkung' => $this->bemerkung,
        ];
    }


}