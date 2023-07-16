<?php


namespace Librevlad\Leadex\Normalizers;


use Carbon\Carbon;


class DateNormalizer extends Normalizer {

    protected function normalize( $d ) {
        try {
        	// 1974-11-22
            $dd = preg_match( '~[1-9]{4}-[0-9]{1}[1-9]{1}-[0-9]{1}[1-9]{1}~ims', $d ) ? $d : null;

            return $dd;
//            return validator( compact( 'dd' ), [ 'dd' => 'required|date' ] )->passes() ? $dd : null;
        }
        catch ( \Exception $e ) {
            return null;
        }
    }

    protected function validate( $v ) {
        return validator( compact( 'v' ), [ 'v' => 'required|date' ] )->passes();
    }
}
