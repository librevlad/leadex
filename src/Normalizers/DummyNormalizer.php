<?php


namespace Librevlad\Leadex\Normalizers;


use Validator;

class DummyNormalizer extends Normalizer {

    protected function normalize( $email ) {
        return $email;
    }

    protected function validate( $email ) {
        return Validator::make( compact( 'email' ), [ 'email' => 'required' ] )->passes();
    }
}
