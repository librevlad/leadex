<?php


namespace Librevlad\Leadex\Normalizers;

use Str;

class PhoneNormalizer extends Normalizer {

	protected function normalize( $_phone ) {

		$phone = (int) preg_replace( '~[^0-9]*~ims', '', $_phone );


		if ( strpos( $phone, '1234' ) ) {
			return null;
		}

		// remove 11111
		$digitStats = [];
		for ( $i = 0; $i < strlen( $phone ); $i ++ ) {
			$digit = substr( $phone, $i, 1 );

			$digitStats[ $digit ] = isset( $digitStats[ $digit ] ) ? $digitStats[ $digit ] + 1 : 1;
		}
		foreach ( $digitStats as $digit => $count ) {
			if ( $count > 5 ) {
				return null;
			}
		}

		if ( strlen( $phone ) == 11 ) {
			if ( str_starts_with( $phone, '89' ) ) {
				return (int) '79' . mb_substr( $phone, 2 );
			}
		}
		if ( strlen( $phone ) == 10 ) {
			if ( str_starts_with( $phone, '9' ) ) {
				return (int) '7' . $phone;
			}
		}
		if ( strlen( $phone ) == 9 ) {
			return (int) '79' . $phone;
		}

		if ( trim( $phone ) == '' ) {
			return null;
		}

		//var_dump($phone);
		return (int) $phone;
	}

	protected function validate( $phone ) {
		return ( mb_strlen( $phone ) == 11 ) && str_starts_with( $phone, '79' );
	}
}
