<?php


namespace Librevlad\Leadex\DTO;


class EmailCollection extends ItemCollection {

    public function emails() {
        return $this->items->map->get( 'email' );
    }

    public function add( $item ) {
        if ( $item->valid() ) {
            $this->items[ $item->getKey() ] = $item;
        }
    }
}
