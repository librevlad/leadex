<?php


namespace Librevlad\Leadex\Normalizers;


use Illuminate\Validation\Validator;


class EmailNormalizer extends Normalizer {

	protected function normalize( $email ) {
		$eml = trim( mb_convert_case( $email, MB_CASE_LOWER ) );
		try {
			$parts = @explode( '@', $email );
			if ( strlen( $parts[ 0 ] ) < 6 ) {
				if ( in_array( $parts[ 1 ], [
					'mail.ru',
					'bk.ru',
					'gmail.com',
					'rambler.ru',
					'yandex.ru',
					'ya.ru',
					'test.ru',
				] ) ) {
//					return null;
				}

				try {
//					$host = explode( '.', $parts[ 1 ] );
//					if ( strlen( $host[0] ) < 5 ) {
//						return null;
//					}

				}
				catch ( \Exception $e ) {
					return null;
				}

			}

		}
		catch ( \Exception $e ) {
			return null;
		}

		return $eml;
	}

	protected function validate( $email ) {
		return validator( compact( 'email' ), [ 'email' => 'required|email' ] )->passes();
	}
}
