<?php


namespace Librevlad\Leadex\DTO;


use Librevlad\Leadex\Normalizers\Normalizer;

abstract class BaseDTO {

    protected $data;

    /**
     * @return Normalizer
     */
    abstract public function getNormalizer();

    abstract public function equals( $dto );

    public function valid() {
        return $this->getNormalizer()->normalizedIsValid();
    }

    public function get() {
        return $this->data;
    }

    abstract public function getKey();

    public function __construct( $data ) {
        $this->data = $data;
        $this->data = $this->getNormalizer()->getNormalized();
        //        dump( 'thisdata', $data, '/+/', $this->data, '/-' );
    }
}
