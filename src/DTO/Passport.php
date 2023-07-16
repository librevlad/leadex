<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasScalarKey;
use Librevlad\Leadex\Normalizers\InlineNormalizer;
use Librevlad\Leadex\Normalizers\PhoneNormalizer;
use Librevlad\Leadex\Normalizers\TrimCapitalizeNormalizer;
use Librevlad\Leadex\Normalizers\ZipNormalizer;

class Passport extends ArrayDTO {

	protected $data = [
		'series'          => null,
		'number'          => null,
		'issue_authority' => null,
		'issue_date'      => null,
	];

	public function getNormalizer() {
		return new InlineNormalizer( $this->data, function ( $data ) {
			$data[ 'series' ]          = strlen( $data[ 'series' ] ) == 4 ? $data[ 'series' ] : null;
			$data[ 'number' ]          = strlen( $data[ 'number' ] ) == 6 ? $data[ 'number' ] : null;
			$data[ 'issue_authority' ] = strlen( $data[ 'issue_authority' ] ) > 10 ? $data[ 'issue_authority' ] : null;
			$data[ 'issue_date' ]      = strlen( $data[ 'issue_date' ] ) > 7 ? $data[ 'issue_date' ] : null;

			return $data;
		}, function ( $data ) {
			return strlen( $data[ 'series' ] ) == 4
			       && strlen( $data[ 'number' ] ) == 6;
		} );
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	protected function normalizeInput( $data ): array {
		if ( ! is_array( $data ) ) {
			$data = [
				'series'          => null,
				'number'          => null,
				'issue_authority' => null,
				'issue_date'      => null,
			];
		}

		return $data;
	}

	public function getKey() {
		return $this->data[ 'series' ] . $this->data[ 'number' ] . $this->data[ 'issue_authority' ] . $this->data[ 'issue_date' ];
	}
}
