<?php


namespace Librevlad\Leadex\Choosers;


use Librevlad\Leadex\Normalizers\Normalizer;

class StringChooser extends Chooser {

    protected function choose( Normalizer $first, Normalizer $second, $default ) {

        if ( $this->onlyOneNormalizedValid() ) {
            return $this->getTheOnlyValid();
        }

        if ( $this->bothNormalizedValid() ) {
            return strlen( $second->finalValue() ) > strlen( $first->finalValue() ) ? $second : $first;
        }

        return $default;

    }
}
