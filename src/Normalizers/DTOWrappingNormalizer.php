<?php


namespace Librevlad\Leadex\Normalizers;


class DTOWrappingNormalizer extends Normalizer {

    protected function normalize( $dto ) {
        return $dto->getNormalizer()->normalize( $dto );
    }

    protected function validate( $dto ) {
        return $dto->getNormalizer()->validate( $dto );
    }
}
