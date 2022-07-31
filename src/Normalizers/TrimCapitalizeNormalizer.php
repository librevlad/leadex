<?php


namespace Librevlad\Leadex\Normalizers;


use Validator;

class TrimCapitalizeNormalizer extends Normalizer {

	protected function normalize( $email ) {
		return trim( mb_convert_case( $email, MB_CASE_TITLE_SIMPLE ) );
	}

	protected function validate( $v ) {
		return Validator::make( compact( 'v' ), [ 'v' => 'required|string|min:2' ] )->passes();
	}
}
