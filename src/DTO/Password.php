<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\DTO\Concerns\HasScalarKey;
use Librevlad\Leadex\Normalizers\InlineNormalizer;
use Librevlad\Leadex\Normalizers\PhoneNormalizer;
use Librevlad\Leadex\Normalizers\TrimCapitalizeNormalizer;
use Librevlad\Leadex\Normalizers\ZipNormalizer;

class Password extends ArrayDTO {
    use HasScalarKey;

    protected $key = 'password';


    protected $data = [
        'hash_type' => 'plain',
        'password'  => null,
    ];

    public function getNormalizer() {
        return new InlineNormalizer( $this->data, function ( $data ) {
            $data[ 'password' ] = strlen( $data[ 'password' ] ) > 2 ? $data[ 'password' ] : null;

            return $data;
        }, function ( $data ) {
            return strlen( $data[ 'password' ] ) > 2;
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
                'hash_type' => 'plain',
                'password' => $data,
            ];
        }

        return $data;
    }
}
