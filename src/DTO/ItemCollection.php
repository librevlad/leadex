<?php


namespace Librevlad\Leadex\DTO;


class ItemCollection {

    protected $items = [];

    public function __construct() {
        $this->items = collect();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function items() {
        return $this->items;
    }

    public function add( $item ) {

        if ( $item->valid() ) {
            $this->items[ $item->getKey() ] = $item;
        } else {
            //            console()->line( 'Item not valid, skipping: ' . $item->getKey() );
        }
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

    public function toArray() {
        $itms = $this->items()->map->get()->toArray();

        return $itms;
    }
}
