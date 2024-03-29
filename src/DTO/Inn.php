<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasNormalizerClass;
use Librevlad\Leadex\Normalizers\InnNormalizer;
use Librevlad\Leadex\Normalizers\SnilsNormalizer;
use Librevlad\Leadex\Normalizers\InlineNormalizer;

class Inn extends ScalarDTO {

	public function getNormalizer() {
		// 11 цифр
		$norm = new InlineNormalizer( $this->data, function ( $data ) {
			$data = ( new InnNormalizer( $data ) )->finalValue();

			return $data;
		}, function ( $data ) {
			return ( new InnNormalizer( $data ) )->normalizedIsValid();
		} );

		return $norm;
	}
	public function equals( $dto ) {
		return $this->get() == $dto->get();
	}
}
