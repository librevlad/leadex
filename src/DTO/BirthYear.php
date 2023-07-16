<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasNormalizerClass;
use Librevlad\Leadex\Normalizers\BirthYearNormalizer;
use Librevlad\Leadex\Normalizers\InnNormalizer;
use Librevlad\Leadex\Normalizers\SnilsNormalizer;
use Librevlad\Leadex\Normalizers\InlineNormalizer;

class BirthYear extends ScalarDTO {

	public function getNormalizer() {
		// 4 цифр
		$norm = new InlineNormalizer( $this->data, function ( $data ) {
			$data = ( new BirthYearNormalizer( $data ) )->finalValue();

			return $data;
		}, function ( $data ) {
			return ( new BirthYearNormalizer( $data ) )->normalizedIsValid();
		} );

		return $norm;
	}
	public function equals( $dto ) {
		return $this->get() == $dto->get();
	}
}
