<?php


namespace Librevlad\Leadex\Normalizers;

use Validator;

class ArrayNormalizer extends Normalizer {

    protected function normalize( $a ) {
        return is_array( $a ) ? $a : [ $a ];
    }

    protected function validate( $v ) {
        return Validator::make( compact( 'v' ), [ 'v' => 'required|array' ] )->passes();
    }
}
