<?php


namespace Librevlad\Leadex\Normalizers;


use Validator;

class NoRepeatNormalizer extends Normalizer {

	protected function normalize( $v ) {
		$letterstats = [];

		for ( $i = 0; $i < strlen( $v ); $i ++ ) {
			$digit = trim( mb_convert_case( mb_substr( $v, $i, 1 ), MB_CASE_LOWER ) );

			$letterstats[ $digit ] = isset( $letterstats[ $digit ] ) ? $letterstats[ $digit ] + 1 : 1;
		}

		if ( count( $letterstats ) < 2 ) {
			return null;
		}


		return $v;
	}

	protected function validate( $v ) {
		return Validator::make( compact( 'v' ), [ 'v' => 'required|string|min:2' ] )->passes();
	}
}
