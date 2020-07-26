<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasNormalizerClass;
use Librevlad\Leadex\Normalizers\DateNormalizer;

class Birthday extends ScalarDTO {
    use HasNormalizerClass;

    protected $normalizerClass = DateNormalizer::class;


    public function equals( $dto ) {
        return $this->get() == $dto->get();
    }
}
