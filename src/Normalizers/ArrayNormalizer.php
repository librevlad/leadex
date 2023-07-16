<?php


namespace Librevlad\Leadex\Normalizers;

use Illuminate\Validation\Validator;


class ArrayNormalizer extends Normalizer {

    protected function normalize( $a ) {
        return is_array( $a ) ? $a : [ $a ];
    }

    protected function validate( $v ) {
        return validator( compact( 'v' ), [ 'v' => 'required|array' ] )->passes();
    }
}
