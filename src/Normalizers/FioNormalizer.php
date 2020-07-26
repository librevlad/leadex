<?php


namespace Librevlad\Leadex\Normalizers;


class FioNormalizer extends Normalizer {

    protected function normalize( $d ) {
        //        dump( 'b4 normalize', $d, '/-' );
        foreach ( [ 'first_name', 'last_name', 'patronymic' ] as $k ) {
            $d[ $k ] = ( new NoRepeatNormalizer( $d[ $k ] ) )->finalValue();
            $d[ $k ] = ( new AlphaNormalizer( $d[ $k ] ) )->finalValue();
            $d[ $k ] = ( new TrimCapitalizeNormalizer( $d[ $k ] ) )->finalValue();
            $d[ $k ] = mb_substr( $d[ $k ], 0, 29, 'UTF-8' );
            $d[ $k ] = mb_strlen( $d[ $k ] ) < 2 ? null : $d[ $k ];
            //            dump( $d[ $k ] );
        }

        //        dd($d);
        //        $d[ 'first_name' ] = ( new NoRepeatNormalizer( $d[ 'first_name' ] ) )->finalValue();
        //        $d[ 'first_name' ] = ( new AlphaNormalizer( $d[ 'first_name' ] ) )->finalValue();
        //        $d[ 'first_name' ] = ( new TrimCapitalizeNormalizer( $d[ 'first_name' ] ) )->finalValue();
        //        $d[ 'first_name' ] = mb_substr( $d[ 'first_name' ], 0, 29, 'UTF-8' );

        //        dump( 'after normalize', $d, '/-' );
        return $d;
    }

    protected function validate( $v ) {
        //        dump( 'vee', $v );
        return $v[ 'first_name' ] || $v[ 'last_name' ] || $v[ 'patronymic' ];
    }
}
