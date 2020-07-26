<?php


namespace Librevlad\Leadex\DTO\Concerns;

trait HasScalarKey {

    public function getKey() {
        return $this->data[ $this->key ];
    }
}
