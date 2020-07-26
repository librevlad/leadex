<?php


namespace Librevlad\Leadex\DTO;


abstract class ScalarDTO extends BaseDTO {

    public function getKey() {
        return $this->data;
    }
}
