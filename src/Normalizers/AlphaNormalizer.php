<?php


namespace Librevlad\Leadex\Normalizers;


use Validator;

class AlphaNormalizer extends Normalizer {

    protected function normalize( $v ) {
        return preg_replace( '~[^A-Za-zА-Яа-я]~uims', '', $v );
    }

    protected function validate( $v ) {
        return Validator::make( compact( 'v' ), [ 'v' => 'required|string|min:2' ] )->passes();
    }
}
