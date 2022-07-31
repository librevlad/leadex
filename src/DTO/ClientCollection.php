<?php


namespace Librevlad\Leadex\DTO;


class ClientCollection {

	protected $items = [];

	/**
	 * In-memory indexes
	 */
	protected $phones = [];
	protected $emails = [];

	public function __construct() {
		$this->items  = collect();
		$this->emails = collect();
		$this->phones = collect();
	}

	public function count() {
		return $this->items->count();
	}

	public function toArray() {
		$map = $this->items->map->toArray()
		                        ->toArray();

		//        dd($map);
		return $map;
	}

	public function toJson() {
		return json_encode( $this->toArray(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
	}

	public function add( Client $client ) {
		// skip clients without contacts
		if (
			! $client->phones()->numbers()->count()
			&& ! $client->emails()->emails()->count()
		) {
			return;
		}

		$clientsOnPhones = $this->phones->only( $client->phones()->numbers() );
		$clientsOnEmails = $this->emails->only( $client->emails()->emails() );

		$conflictingClients = $clientsOnPhones->merge( $clientsOnEmails );

		while ( $conflictingClients->count() > 0 ) {
			$conflictingClient = $this->items[ $conflictingClients->first() ];

			$client->merge( $conflictingClient );

			$this->removeClient( $conflictingClient );

			return $this->add( $client );
		}

		// No conflicting clients

		foreach ( $client->phones()->numbers() as $number ) {
			$this->phones[ $number ] = $client->uuid;
		}

		foreach ( $client->emails()->emails() as $e ) {
			$this->emails[ $e ] = $client->uuid;
		}

		$this->items[ $client->uuid ] = $client;

	}

	public function removeBadClients( callable $callback = null ) {

		foreach ( $this->items as $item ) {

			/**
			 * @var $item Client
			 */
			if ( $item->fios()->items()->count() > 4 ) {
				$this->removeClient( $item );

				continue;
			}
			if ( $item->phones()->items()->count() > 3 ) {
				$this->removeClient( $item );

				continue;
			}
			if ( $item->emails()->items()->count() > 3 ) {
				$this->removeClient( $item );

				continue;
			}

			if ( is_callable( $callback ) && $callback( $item ) ) {
				$this->removeClient( $item );

				continue;
			}
		}

	}

	/**
	 * @param $conflictingClient
	 */
	protected function removeClient( $conflictingClient ): void {
		$this->phones->forget( $conflictingClient->phones()->numbers()->toArray() );
		$this->emails->forget( $conflictingClient->emails()->emails()->toArray() );
		unset( $this->items[ $conflictingClient->uuid ] );
	}
}
