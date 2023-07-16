<?php


namespace Librevlad\Leadex\Normalizers;

use Str;

class InnNormalizer extends Normalizer {

	protected function normalize( $_val ) {

		$value = (int) preg_replace( '~[^0-9]*~ims', '', $_val );

		return $value;
	}

	protected function validate( $value ) {
		return ( mb_strlen( $value ) == 12 );
	}
}
