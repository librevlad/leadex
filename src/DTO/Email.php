<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasScalarKey;
use Librevlad\Leadex\Normalizers\EmailNormalizer;
use Librevlad\Leadex\Normalizers\InlineNormalizer;
use Librevlad\Leadex\Normalizers\Normalizer;
use Librevlad\Leadex\Normalizers\PhoneNormalizer;

class Email extends ArrayDTO {
    use HasScalarKey;

    protected $key = 'email';

    protected $data = [
        'email' => null,
        'alive' => null,
    ];

    public function getNormalizer() {
        $norm = new InlineNormalizer( $this->data, function ( $data ) {
            $data[ 'email' ] = ( new EmailNormalizer( $data[ 'email' ] ) )->finalValue();

            return $data;
        }, function ( $data ) {
            return ( new EmailNormalizer( $data[ 'email' ] ) )->normalizedIsValid();
        } );

        return $norm;
    }

    /**
     * @param $data
     *
     * @return array
     */
    protected function normalizeInput( $data ): array {
        if ( ! is_array( $data ) ) {
            $data = [ 'email' => $data ];
        }

        return $data;
    }

    public function equals( $dto ) {
        return $this->get( 'email' ) == $dto->get( 'email' );
    }
}
