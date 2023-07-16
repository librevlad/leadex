<?php


namespace Librevlad\Leadex\Normalizers;


use Illuminate\Validation\Validator;


class DummyNormalizer extends Normalizer {

    protected function normalize( $email ) {
        return $email;
    }

    protected function validate( $email ) {
        return validator( compact( 'email' ), [ 'email' => 'required' ] )->passes();
    }
}
