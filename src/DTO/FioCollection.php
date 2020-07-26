<?php


namespace Librevlad\Leadex\DTO;


class FioCollection extends ItemCollection {

    /**
     * @param $item Fio
     */
    public function add( $item ) {

        if ( $item->valid() ) {
            $this->items[ $item->getKey() ] = $item;
        } else {
            //            console()->line( 'Item not valid, skipping: ' . $item->getKey() );
        }
        $this->deduplicate();
    }

    public function diff( ItemCollection $other ) {
        $differentValues = collect();
        foreach ( $other->items() as $item ) {

            if ( ! $this->items->has( $item->getKey() ) ) {

                // we dont have this value, add it to diff
                $differentValues[ $item->getKey() ] = $item;
            } else {
                // see if they are equal
                $ourItem = $this->items->get( $item->getKey() );
                if ( ! $ourItem->equals( $item ) ) {
                    $differentValues[ $item->getKey() ] = $item;
                }
            }
        }


        return $differentValues;

    }

    public function deduplicate() {
        foreach ( $this->items() as $key => $fio ) {

            // Deduplicating fio against all fios
            foreach ( $this->items()->except( $key ) as $otherKey => $otherFio ) {

                if ( $otherFio->contains( $fio ) ) {
                    $this->items()->forget( $key );
                }
            }

        }
    }

}
