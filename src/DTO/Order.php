<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasScalarKey;
use Librevlad\Leadex\Normalizers\InlineNormalizer;
use Librevlad\Leadex\Normalizers\PhoneNormalizer;
use Librevlad\Leadex\Normalizers\TrimCapitalizeNormalizer;

class Order extends ArrayDTO {
    use HasScalarKey;

    protected $key = 'items';

    protected $data = [
        'items'  => null,
        'amount' => null,
    ];

    public function getNormalizer() {
        return new InlineNormalizer( $this->data, function ( $data ) {
            $data[ 'items' ]  = mb_substr( ( new TrimCapitalizeNormalizer( $data[ 'items' ] ) )->finalValue(), 0, 512 );
            $data[ 'amount' ] = abs( (int) $data[ 'amount' ] );

            return $data;
        }, function ( $data ) {
            $norm  = new TrimCapitalizeNormalizer( $data[ 'items' ] );
            $valid = $norm->normalizedIsValid();

            return $valid;
        } );
    }

    /**
     * @param $data
     *
     * @return array
     */
    protected function normalizeInput( $data ): array {
        if ( ! is_array( $data ) ) {
            $data = [ 'items' => $data, 'amount' => null ];
        }

        return $data;
    }

    public function equals( $dto ) {
        return $this->get( 'items' ) == $dto->get( 'items' );
    }
}
