<?php


namespace Librevlad\Leadex\DTO;


abstract class ArrayDTO extends BaseDTO {

    protected $data = [];

    public function __construct( $data ) {
        if ( method_exists( $this, 'normalizeInput' ) ) {
            $data = $this->normalizeInput( $data );
        }
        $this->data = array_replace( $this->data, $data );
        //        dump( 'this data', $this->data, '/-' );
        $this->data = $this->getNormalizer()->getNormalized();
        //        dump( 'this data after normalize', $this->data, '/-' );
    }

    public function toArray() {
        return $this->data;
    }

    public function get( $key = null ) {
        if ( $key ) {
            return $this->data[ $key ];
        }

        return $this->data;
    }

    public function equals( $dto ) {
        return $this->getKey() == $dto->getKey();
    }
}
