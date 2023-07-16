<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasNormalizerClass;
use Librevlad\Leadex\Normalizers\SnilsNormalizer;
use Librevlad\Leadex\Normalizers\InlineNormalizer;

class Snils extends ScalarDTO {

	public function getNormalizer() {
		// 11 цифр
		$norm = new InlineNormalizer( $this->data, function ( $data ) {
			$data[ 'snils' ] = ( new SnilsNormalizer( $data[ 'snils' ] ) )->finalValue();

			return $data;
		}, function ( $data ) {
			return ( new SnilsNormalizer( $data[ 'snils' ] ) )->normalizedIsValid();
		} );

		return $norm;
	}
	public function equals( $dto ) {
		return $this->get() == $dto->get();
	}
}
