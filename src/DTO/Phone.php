<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasScalarKey;
use Librevlad\Leadex\Normalizers\InlineNormalizer;
use Librevlad\Leadex\Normalizers\Normalizer;
use Librevlad\Leadex\Normalizers\PhoneNormalizer;
use Librevlad\PhoneInfo\PhoneInfo;

class Phone extends ArrayDTO {
    use HasScalarKey;

    protected $key = 'phone';

	protected $data = [
		'phone'       => null,
		'alive'       => null,
		'is_landline' => null,
		'country'     => null,
	];
	public function getNormalizer() {

		return new InlineNormalizer( $this->data, function ( $data ) {

			$phone = ( new PhoneNormalizer( $data[ 'phone' ] ) )->finalValue();
			$db    = new PhoneInfo( $phone );

			$data = [
				'phone'       => $phone,
				'alive'       => ! ! $data[ 'alive' ],
				'is_landline' => ! ! $db->isLandline(),
			];

			return $data;
		}, function ( $data ) {
			return ( new PhoneNormalizer( $data[ 'phone' ] ) )->normalizedIsValid();
		} );
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	protected function normalizeInput( $data ): array {
		if ( ! is_array( $data ) ) {
			$data = [ 'phone' => $data ];
		}

		$phone = ( new PhoneNormalizer( $data[ 'phone' ] ) )->finalValue();
		$db    = new PhoneInfo( $phone );

		$data [ 'is_landline' ] = $db->isLandline();
		$data [ 'country' ]     = $db->country();

		return $data;
	}

    public function equals( $dto ) {
        return $this->get( 'phone' ) == $dto->get( 'phone' );
    }


	/**
	 * @return PhoneInfo
	 */
	public function info() {
		return new PhoneInfo( $this->get( 'phone' ) );
	}
}
