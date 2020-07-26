<?php


namespace Librevlad\Leadex\Normalizers;


use Validator;

class StreetAddressNormalizer extends Normalizer {

    protected function normalize( $v ) {
        return substr( trim( $v ), 0, 255 );
    }

    protected function validate( $v ) {
        return Validator::make( compact( 'v' ), [ 'v' => 'required|min:2|max:256' ] )->passes();
    }
}
