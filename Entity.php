<?php

class Entity
{
    public function toArray()
    {
        $data = get_object_vars($this);
        return $data;
    }
}