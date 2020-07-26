<?php


namespace Librevlad\Leadex\DTO;


class PhoneCollection extends ItemCollection {

    public function numbers() {
        return $this->items->map->get( 'phone' );
    }

    public function add( $item ) {
        if ( $item->valid() ) {
            $this->items[ $item->getKey() ] = $item;
        } else {
        }
    }
}
