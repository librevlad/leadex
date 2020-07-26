<?php


namespace Librevlad\Leadex\Normalizers;


abstract class Normalizer {

    /**
     * @var null
     */
    public $default;
    protected $original;
    protected $normalized;

    protected $original_is_valid = false;
    protected $normalized_is_valid = false;

    /**
     * @return mixed
     */
    public function getOriginal() {
        return $this->original;
    }

    /**
     * @return mixed
     */
    public function getNormalized() {
        return $this->normalized;
    }

    /**
     * Normalizer constructor.
     *
     * @param $original
     */
    public function __construct( $original, $default = null ) {
        $this->original            = $original;
        $this->original_is_valid   = $this->validate( $original );
        $this->normalized          = $this->normalize( $original );
        $this->normalized_is_valid = $this->validate( $this->normalized );
        $this->default             = $default;
    }

    abstract protected function normalize( $value );

    abstract protected function validate( $value );

    public function originalIsValid() {
        return $this->original_is_valid;
    }

    public function originalIsNormalized() {
        return ( $this->original === $this->normalized );
    }

    public function normalizedIsFinalValue() {
        return ( $this->normalized === $this->finalValue() );
    }

    public function normalizedIsValid() {
        return $this->normalized_is_valid;
    }

    public function finalValue() {
        return $this->normalized_is_valid ? $this->normalized : $this->default;
    }
}
