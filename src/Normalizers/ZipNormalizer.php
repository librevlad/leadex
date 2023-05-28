<?php


namespace Librevlad\Leadex\Normalizers;


use Validator;

class ZipNormalizer extends Normalizer {

    protected function normalize( $v ) {
        return (int) abs( (int) substr( trim( $v ), 0, 6 ));
    }

    protected function validate( $v ) {
        return Validator::make( compact( 'v' ), [ 'v' => 'required|numeric' ] )->passes();
    }
}
