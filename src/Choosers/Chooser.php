<?php


namespace Librevlad\Leadex\Choosers;


use Librevlad\Leadex\Normalizers\DummyNormalizer;
use Librevlad\Leadex\Normalizers\Normalizer;

abstract class Chooser {

    /**
     * @var Normalizer
     */
    protected $first;
    /**
     * @var Normalizer
     */
    protected $second;
    /**
     * @var Normalizer
     */
    protected $chosen;
    /**
     * @var Normalizer
     */
    protected $default;


    /**
     * Chooser constructor.
     *
     * @param $one
     * @param $two
     */
    public function __construct( $first, $second, $normalizerClass = null, $default = null ) {

        if ( ! $normalizerClass ) {
            $normalizerClass = DummyNormalizer::class;
        }

        $this->first   = new $normalizerClass( $first );
        $this->second  = new $normalizerClass( $second );
        $this->default = new $normalizerClass( $default );

        $this->chosen = $this->choose( $this->first, $this->second, $default );
    }

    public static function make( ...$args ) {
        return new static( ...$args );
    }

    abstract protected function choose( Normalizer $first, Normalizer $second, $default );

    public function chosen(): Normalizer {
        return $this->chosen;
    }

    public function firstIsChosen() {
        return $this->chosen == $this->first;
    }

    public function secondIsChosen() {
        return $this->chosen == $this->second;
    }

    public function firstEqualsSecond() {
        return $this->first == $this->second;
    }

    public function defaultIsChosen() {
        return $this->chosen == $this->default;
    }


    /**
     *
     */

    protected function bothNormalizedValid() {
        return $this->first->normalizedIsValid() && $this->second->normalizedIsValid();
    }

    protected function onlyOneNormalizedValid() {
        return ! $this->first->normalizedIsValid() || ! $this->second->normalizedIsValid();
    }

    protected function getTheOnlyValid() {
        if ( ! $this->onlyOneNormalizedValid() ) {
            return null;
        }

        if ( $this->first->normalizedIsValid() ) {
            return $this->first;
        }

        return $this->second;
    }

}
