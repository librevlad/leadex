<?php /** @noinspection PhpUndefinedClassInspection */


namespace Librevlad\Leadex\DTO;

use Librevlad\Fiona\Detector;
use Librevlad\Leadex\DTO\Concerns\HasNormalizerClass;
use Librevlad\Leadex\Normalizers\FioNormalizer;
use Illuminate\Support\Arr;

class Fio extends ArrayDTO implements \Stringable {
	use HasNormalizerClass;

	protected $normalizerClass = FioNormalizer::class;

	protected $data = [
		'first_name'         => null,
		'patronymic'         => null,
		'last_name'          => null,
		'gender'             => null,
		'unmatched_segments' => [],
	];
	/**
	 * @var Detector
	 */
	private static $fiona;

	protected function replaceDoubleSpaces( $string ) {
		return str_replace( '  ', ' ', str_replace( '  ', ' ', $string ) );
	}

	public function getKey() {
		return trim( $this->replaceDoubleSpaces( implode( ' ', Arr::only( $this->data, [
			'first_name',
			'patronymic',
			'last_name',
		] ) ) ) );

	}

	/**
	 * @param $data
	 *
	 * @return string
	 */
	protected function normalizeInput( $data ): array {

		if ( is_array( $data ) ) {
			$data = trim( $this->replaceDoubleSpaces( Arr::get( $data, 'first_name' ) . ' ' . Arr::get( $data, 'patronymic' ) . ' ' . Arr::get( $data, 'last_name' ) ) );
		}

		if( !self::$fiona) {
//			echo 'init detector';
			self::$fiona = new Detector();
		}

		$data  = self::$fiona->detect( $data,true );

		return $data;
	}

	public function contains( Fio $otherFio ) {

		if ( $part = $otherFio->get( 'first_name' ) ) {
			if ( $part != $this->get( 'first_name' ) ) {
				return false;
			}
		}

		if ( $part = $otherFio->get( 'last_name' ) ) {
			if ( $part != $this->get( 'last_name' ) ) {
				return false;
			}
		}

		if ( $part = $otherFio->get( 'patronymic' ) ) {
			if ( $part != $this->get( 'patronymic' ) ) {
				return false;
			}
		}

		return true;

	}

	public function equals( $dto ) {
		return
			( $this->get( 'first_name' ) == $dto->get( 'first_name' ) )
			&& ( $this->get( 'last_name' ) == $dto->get( 'last_name' ) )
			&& ( $this->get( 'patronymic' ) == $dto->get( 'patronymic' ) )

			/**//**/ ;
	}

	public function __toString() {
		// TODO: Implement __toString() method.
		return $this->getKey();
	}
}
