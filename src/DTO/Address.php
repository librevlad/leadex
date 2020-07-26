<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasScalarKey;
use Librevlad\Leadex\Normalizers\InlineNormalizer;
use Librevlad\Leadex\Normalizers\PhoneNormalizer;
use Librevlad\Leadex\Normalizers\TrimCapitalizeNormalizer;
use Librevlad\Leadex\Normalizers\ZipNormalizer;

class Address extends ArrayDTO {
    //    use HasScalarKey;

    //    protected $key = 'street_address';

    protected $data = [
        'country'        => 'Россия',
        'state'          => null,
        'zip'            => null,
        'city'           => null,
        'street_address' => null,
        'extra'          => null,
    ];

    public function getNormalizer() {
        return new InlineNormalizer( $this->data, function ( $data ) {
            $data[ 'country' ]        = mb_substr( ( new TrimCapitalizeNormalizer( $data[ 'country' ] ) )->finalValue(), 0, 48 ) ?: 'Россия';
            $data[ 'state' ]          = mb_substr( ( new TrimCapitalizeNormalizer( $data[ 'state' ] ) )->finalValue(), 0, 48 );
            $data[ 'zip' ]            = ( new ZipNormalizer( $data[ 'zip' ] ) )->finalValue();
            $data[ 'city' ]           = mb_substr( ( new TrimCapitalizeNormalizer( $data[ 'city' ] ) )->finalValue(), 0, 48 );
            $data[ 'street_address' ] = mb_substr( ( new TrimCapitalizeNormalizer( $data[ 'street_address' ] ) )->finalValue(), 0, 256 );
            $data[ 'extra' ]          = mb_substr( ( new TrimCapitalizeNormalizer( $data[ 'extra' ] ) )->finalValue(), 0, 512 );

            return $data;
        }, function ( $data ) {
            $norm     = collect();
            $norm  [] = new TrimCapitalizeNormalizer( $data[ 'state' ] );
            $norm  [] = new TrimCapitalizeNormalizer( $data[ 'zip' ] );
            $norm  [] = new TrimCapitalizeNormalizer( $data[ 'city' ] );
            $norm  [] = new TrimCapitalizeNormalizer( $data[ 'street_address' ] );
            $norm  [] = new TrimCapitalizeNormalizer( $data[ 'extra' ] );

            $norm = $norm->map->finalValue()->toArray();

            $norm = implode( ' ', $norm );
            $norm = str_replace( ' ', '', $norm );


            return strlen( $norm ) > 3;
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
                'country'        => 'Россия',
                'state'          => null,
                'zip'            => null,
                'city'           => null,
                'street_address' => $data,
                'extra'          => null,
            ];
        }

        return $data;
    }

    public function getKey() {
        return $this->get( 'state' ) . ' ' . $this->get( 'city' ) . ' ' . $this->get( 'street_address' );
    }
}
