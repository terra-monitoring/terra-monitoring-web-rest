<?php

namespace TerraMonitoring\Web\Entity;

/**
 * Created by IntelliJ IDEA.
 * User: czoeller
 * Date: 27.04.16
 * Time: 17:01
 */
class Animal implements \JsonSerializable
{
    private $id;
    private $name;

    /**
     * Animal constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     * @return Animal
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return [
            'id'     => $this->id,
            'name' => $this->name,
        ];
    }
}