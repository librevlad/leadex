<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasScalarKey;
use Librevlad\Leadex\Normalizers\InlineNormalizer;
use Librevlad\Leadex\Normalizers\PhoneNormalizer;

class Phone extends ArrayDTO {
    use HasScalarKey;

    protected $key = 'phone';

    protected $data = [
        'phone' => null,
        'alive' => null,
        'type'  => null,
    ];

    public function getNormalizer() {
        return new InlineNormalizer( $this->data, function ( $data ) {
            $data[ 'phone' ] = ( new PhoneNormalizer( $data[ 'phone' ] ) )->finalValue();

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

        return $data;
    }

    public function equals( $dto ) {
        return $this->get( 'phone' ) == $dto->get( 'phone' );
    }
}
