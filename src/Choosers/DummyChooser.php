<?php


namespace Librevlad\Leadex\Choosers;


use Librevlad\Leadex\Normalizers\Normalizer;

class DummyChooser extends Chooser {

    protected function choose( Normalizer $first, Normalizer $second, $default ) {

        if ( $this->onlyOneNormalizedValid() ) {
            return $this->getTheOnlyValid();
        }

        if ( $this->bothNormalizedValid() ) {
            return $first;
        }

        return $default;
    }
}
