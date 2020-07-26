<?php


namespace Librevlad\Leadex\Normalizers;


use Carbon\Carbon;
use Validator;

class DateNormalizer extends Normalizer {

    protected function normalize( $d ) {
        try {
            $dd = preg_match( '~[1-9]{4}-[0-9]{1}[1-9]{1}-[0-9]{1}[1-9]{1}~ims', $d ) ? $d : null;

            return Validator::make( compact( 'dd' ), [ 'dd' => 'required|date' ] )->passes() ? $dd : null;
        }
        catch ( \Exception $e ) {
            return null;
        }
    }

    protected function validate( $v ) {
        return Validator::make( compact( 'v' ), [ 'v' => 'required|date' ] )->passes();
    }
}
