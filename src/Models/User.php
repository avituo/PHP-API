<?php

namespace Src\Models;

class User {
    public $id;
    public $name;
    public $contacts = [];

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getContacts() {
        return $this->contacts;
    }

    public function setContacts($contacts) {
        $this->contacts = $contacts;
    }
}