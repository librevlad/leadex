<?php


namespace Librevlad\Leadex\DTO\Concerns;

use Librevlad\Leadex\Normalizers\DummyNormalizer;

trait HasNormalizerClass {

    public function getNormalizer() {
        $normalizer = $this->normalizerClass ?? DummyNormalizer::class;

        return new $normalizer( $this->data );
    }
}
