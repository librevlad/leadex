<?php


namespace Librevlad\Leadex\Normalizers;


class InlineNormalizer extends Normalizer {

    protected $normalizeFn;
    protected $validateFn;

    public function __construct( $original, callable $normalizeFn, callable $validateFn, $default = null ) {
        $this->original    = $original;
        $this->normalizeFn = $normalizeFn;
        $this->validateFn  = $validateFn;

        $this->original_is_valid   = $this->validate( $original );
        $this->normalized          = $this->normalize( $original );
        $this->normalized_is_valid = $this->validate( $this->normalized );
        $this->default             = $default;
    }

    protected function normalize( $d ) {
        $fn = $this->normalizeFn;

        return $fn( $d );
    }

    protected function validate( $v ) {
        $fn = $this->validateFn;

        return $fn( $v );
    }
}
