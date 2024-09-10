<?php

namespace Src\Models;

class Contacts {
    private $id;
    private $user_id;
    private $type;
    private $value;

    public function __construct($id, $user_id, $type, $value)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->type = $type;
        $this->value = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

}