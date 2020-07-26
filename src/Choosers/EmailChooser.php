<?php


namespace Librevlad\Leadex\Choosers;


use Librevlad\Leadex\Normalizers\Normalizer;

class EmailChooser extends Chooser {

    protected function choose( Normalizer $first, Normalizer $second, $default ) {

        if ( $this->bothNormalizedValid() ) {
            return $first;
        }

        if ( $this->onlyOneNormalizedValid() ) {
            return $this->getTheOnlyValid();
        }

        return $default;

    }
}
