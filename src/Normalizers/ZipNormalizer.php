<?php


namespace Librevlad\Leadex\Normalizers;


use Illuminate\Validation\Validator;


class ZipNormalizer extends Normalizer {

    protected function normalize( $v ) {
        return (int) abs( substr( trim( $v ), 0, 6 ));
    }

    protected function validate( $v ) {
        return validator( compact( 'v' ), [ 'v' => 'required|numeric' ] )->passes();
    }
}
