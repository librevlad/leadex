<?php


namespace Librevlad\Leadex\Normalizers;


use Illuminate\Validation\Validator;


class StreetAddressNormalizer extends Normalizer {

    protected function normalize( $v ) {
        return substr( trim( $v ), 0, 255 );
    }

    protected function validate( $v ) {
        return validator( compact( 'v' ), [ 'v' => 'required|min:2|max:256' ] )->passes();
    }
}
