<?php /** @noinspection PhpUndefinedClassInspection */


namespace Librevlad\Leadex\DTO;

use Librevlad\Leadex\DTO\Concerns\HasNormalizerClass;
use Librevlad\Leadex\Normalizers\FioNormalizer;
use Illuminate\Support\Arr;

class Fio extends ArrayDTO {
    use HasNormalizerClass;

    protected $normalizerClass = FioNormalizer::class;

    protected $data = [
        'first_name'         => null,
        'patronymic'         => null,
        'last_name'          => null,
        'gender'             => null,
        'unmatched_segments' => [],
    ];

    public function getKey() {
        return trim(
            str_replace( '  ', ' ',
                str_replace( '  ', ' ', implode( ' ', Arr::only( $this->data, [
                    'first_name',
                    'patronymic',
                    'last_name',
                ] ) ) ) )
        );
    }

    /**
     * @param $data
     *
     * @return string
     */
    protected function normalizeInput( $data ): array {
        if ( is_array( $data ) ) {
            $data = Arr::get( $data, 'first_name' ) . ' ' . Arr::get( $data, 'patronymic' ) . ' ' . Arr::get( $data, 'last_name' );
            $data = str_replace( ' ', ' ', $data );
            $data = str_replace( ' ', ' ', $data );
            $data = trim( $data );
        }
        $data = app( 'fiona' )->detect( $data );

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
}
