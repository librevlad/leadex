<?php


namespace Librevlad\Leadex\DTO;

use Illuminate\Support\Arr;

class Client {

	protected static $mergeCount = 0;

	public $uuid;

	protected $data = [
		'birthday'   => null,
		'birth_year' => null,
		'inn'        => null,
		'snils'      => null,

		'fios'   => [],
		'phones' => [],
		'emails' => [],

		'orders'    => [],
		'addresses' => [],
		'passwords' => [],
		'passports' => [],
	];

	public function __construct( $data = null ) {

		$birthday  = new Birthday( null );
		$birth_year  = new BirthYear( null );
		$inn  = new Inn( null );
		$snils  = new Snils( null );
		$fios      = new FioCollection();
		$phones    = new PhoneCollection();
		$emails    = new EmailCollection();
		$orders    = new ItemCollection();
		$addresses = new ItemCollection();
		$passwords = new ItemCollection();
		$passports = new ItemCollection();

		if ( ! is_null( $data ) ) {

			if ( isset( $data[ 'birthday' ] ) ) {
				$birthday = new Birthday( $data[ 'birthday' ] );
			}
			if ( isset( $data[ 'birth_year' ] ) ) {
				$birth_year = new BirthYear( $data[ 'birth_year' ] );
			}
			if ( isset( $data[ 'inn' ] ) ) {
				$inn = new Inn( $data[ 'inn' ] );
			}
			if ( isset( $data[ 'snils' ] ) ) {
				$snils = new Snils( $data[ 'snils' ] );
			}
			if ( isset( $data[ 'fios' ] ) ) {
				foreach ( $data[ 'fios' ] as $fio ) {
					$fios->add( new \Librevlad\Leadex\DTO\Fio( $fio ) );
				}
			}

			if ( isset( $data[ 'phones' ] ) ) {
				foreach ( $data[ 'phones' ] as $p ) {
					$phones->add( new \Librevlad\Leadex\DTO\Phone( $p ) );
				}
			}

			if ( isset( $data[ 'emails' ] ) ) {
				foreach ( $data[ 'emails' ] as $p ) {
					$emails->add( new \Librevlad\Leadex\DTO\Email( $p ) );
				}
			}

			if ( isset( $data[ 'orders' ] ) ) {
				foreach ( $data[ 'orders' ] as $p ) {
					$orders->add( new \Librevlad\Leadex\DTO\Order( $p ) );
				}
			}

			if ( isset( $data[ 'addresses' ] ) ) {
				foreach ( $data[ 'addresses' ] as $p ) {
					$addresses->add( new \Librevlad\Leadex\DTO\Address( $p ) );
				}
			}

			if ( isset( $data[ 'passwords' ] ) ) {
				foreach ( $data[ 'passwords' ] as $p ) {
					$passwords->add( new \Librevlad\Leadex\DTO\Password( $p ) );
				}
			}

			if ( isset( $data[ 'passports' ] ) ) {
				foreach ( $data[ 'passports' ] as $p ) {
					$passwords->add( new \Librevlad\Leadex\DTO\Passport( $p ) );
				}
			}

		}

		$this->uuid                 = uniqid();
		$this->data[ 'birthday' ]   = $birthday;
		$this->data[ 'birth_year' ] = $birth_year;
		$this->data[ 'inn' ]        = $inn;
		$this->data[ 'snils' ]      = $snils;
		$this->data[ 'fios' ]       = $fios;
		$this->data[ 'phones' ]     = $phones;
		$this->data[ 'emails' ]     = $emails;
		$this->data[ 'orders' ]     = $orders;
		$this->data[ 'addresses' ]  = $addresses;
		$this->data[ 'passwords' ]  = $passwords;
		$this->data[ 'passports' ]  = $passports;
	}

	public function setBirthday( Birthday $birthday ) {
		$this->data[ 'birthday' ] = $birthday;
	}

	public function setBirthYear( BirthYear $birth_year ) {
		$this->data[ 'birth_year' ] = $birth_year;
	}

	public function setInn( Inn $inn ) {
		$this->data[ 'inn' ] = $inn;
	}

	public function setSnils( Snils $snils ) {
		$this->data[ 'snils' ] = $snils;
	}

	/**
	 * @return FioCollection
	 */
	public function fios() {
		return $this->data[ 'fios' ];
	}

	/**
	 * @return EmailCollection
	 */
	public function emails() {
		return $this->data[ 'emails' ];
	}

	/**
	 * @return ItemCollection
	 */
	public function addresses() {
		return $this->data[ 'addresses' ];
	}

	/**
	 * @return ItemCollection
	 */
	public function passports() {
		return $this->data[ 'passports' ];
	}

	/**
	 * @return ItemCollection
	 */
	public function passwords() {
		return $this->data[ 'passwords' ];
	}

	/**
	 * @return ItemCollection
	 */
	public function orders() {
		return $this->data[ 'orders' ];
	}

	/**
	 * @return PhoneCollection
	 */
	public function phones() {
		return $this->data[ 'phones' ];
	}

	public function equals( Client $other ) {

		return $this->diff( $other ) == [];

	}

	public function toArray() {
		return [
			'birthday'   => $this->data[ 'birthday' ]->get(),
			'birth_year' => $this->data[ 'birth_year' ]->get(),
			'inn'        => $this->data[ 'inn' ]->get(),
			'snils'      => $this->data[ 'snils' ]->get(),
			'fios'       => $this->data[ 'fios' ]->toArray(),
			'phones'     => $this->data[ 'phones' ]->toArray(),
			'emails'     => $this->data[ 'emails' ]->toArray(),
			'orders'     => $this->data[ 'orders' ]->toArray(),
			'addresses'  => $this->data[ 'addresses' ]->toArray(),
			'passwords'  => $this->data[ 'passwords' ]->toArray(),
			'passports'  => $this->data[ 'passports' ]->toArray(),
		];
	}

	public function merge( Client $client ) {

		//        dump( 'merging client' );

		$orig = $this->toArray();

		$diffAsArray = [];
		$diff        = $this->diff( $client );

		if ( isset( $diff[ 'birthday' ] ) ) {
			// choose best birthday
			if ( ! $this->data[ 'birthday' ]->get() ) {
				$this->setBirthday( $diff[ 'birthday' ] );
			}
			$diffAsArray[ 'birthday' ] = $diff[ 'birthday' ]->get();
		}
		if ( isset( $diff[ 'birth_year' ] ) ) {
			// choose best birthday
			if ( ! $this->data[ 'birth_year' ]->get() ) {
				$this->setBirthYear( $diff[ 'birth_year' ] );
			}
			$diffAsArray[ 'birth_year' ] = $diff[ 'birth_year' ]->get();
		}
		if ( isset( $diff[ 'inn' ] ) ) {
			if ( ! $this->data[ 'inn' ]->get() ) {
				$this->setInn( $diff[ 'inn' ] );
			}
			$diffAsArray[ 'inn' ] = $diff[ 'inn' ]->get();
		}
		if ( isset( $diff[ 'snils' ] ) ) {
			if ( ! $this->data[ 'snils' ]->get() ) {
				$this->setInn( $diff[ 'snils' ] );
			}
			$diffAsArray[ 'snils' ] = $diff[ 'snils' ]->get();
		}

		if ( $d = Arr::get( $diff, 'fios', [] ) ) {
			$diffAsArray[ 'fios' ] = [];
			foreach ( $d as $i ) {
				$this->fios()->add( $i );
				$diffAsArray[ 'fios' ] [] = $i->get();
			}
		}

		if ( $d = Arr::get( $diff, 'phones', [] ) ) {
			$diffAsArray[ 'phones' ] = [];
			foreach ( $d as $i ) {
				$this->phones()->add( $i );
				$diffAsArray[ 'phones' ] [] = $i->get();
			}
		}

		if ( $d = Arr::get( $diff, 'emails', [] ) ) {
			$diffAsArray[ 'emails' ] = [];
			foreach ( $d as $i ) {
				$this->emails()->add( $i );
				$diffAsArray[ 'emails' ] [] = $i->get();
			}
		}

		if ( $d = Arr::get( $diff, 'orders', [] ) ) {
			$diffAsArray[ 'orders' ] = [];
			foreach ( $d as $i ) {
				$this->orders()->add( $i );
				$diffAsArray[ 'orders' ] [] = $i->get();
			}
		}

		if ( $d = Arr::get( $diff, 'addresses', [] ) ) {
			$diffAsArray[ 'addresses' ] = [];
			foreach ( $d as $i ) {
				$this->addresses()->add( $i );
				$diffAsArray[ 'addresses' ] [] = $i->get();
			}
		}

		if ( $d = Arr::get( $diff, 'passwords', [] ) ) {
			$diffAsArray[ 'passwords' ] = [];
			foreach ( $d as $i ) {
				$this->passwords()->add( $i );
				$diffAsArray[ 'passwords' ] [] = $i->get();
			}
		}
		if ( $d = Arr::get( $diff, 'passports', [] ) ) {
			$diffAsArray[ 'passports' ] = [];
			foreach ( $d as $i ) {
				$this->passports()->add( $i );
				$diffAsArray[ 'passports' ] [] = $i->get();
			}
		}

		static::$mergeCount ++;

		//        if ( ! empty( $diff ) && ! empty( $client->diff( $this ) ) ) {
		//
		//            $mergeLog = '<table>
		//<thead>
		//<tr>
		//<th>orig</th>
		//<th>merging</th>
		//<th>diff</th>
		//<th>result</th>
		//</tr>
		//</thead>
		//<tr>
		//<td valign="top"><pre>' . print_r( $orig, true ) . '</pre></td>
		//<td valign="top"><pre>' . print_r( $client->toArray(), true ) . '</pre></td>
		//<td valign="top"><pre>' . print_r( $diffAsArray, true ) . '</pre></td>
		//<td valign="top"><pre>' . print_r( $this->toArray(), true ) . '</pre></td>
		//</tr>
		//
		//</table>';
		//            file_put_contents( storage_path( 'mergelog/' . static::$mergeCount . '.html' ), $mergeLog );
		//        }

	}

	public function get( $what = null ) {
		if ( $what ) {
			return $this->data[ $what ];
		}

		return $this->data;
	}

	public function diff( Client $client ) {
		$diff = [];
		if ( $this->data[ 'birthday' ] != $client->data[ 'birthday' ] ) {
			$diff[ 'birthday' ] = $client->data[ 'birthday' ];
		}
		if ( $this->data[ 'birth_year' ] != $client->data[ 'birth_year' ] ) {
			$diff[ 'birth_year' ] = $client->data[ 'birth_year' ];
		}
		if ( $this->data[ 'inn' ] != $client->data[ 'inn' ] ) {
			$diff[ 'inn' ] = $client->data[ 'inn' ];
		}
		if ( $this->data[ 'snils' ] != $client->data[ 'snils' ] ) {
			$diff[ 'snils' ] = $client->data[ 'snils' ];
		}

		$d = $this->fios()->diff( $client->fios() );
		if ( $d->count() ) {
			$diff[ 'fios' ] = $d;
		}

		$d = $this->phones()->diff( $client->phones() );
		if ( $d->count() ) {
			$diff[ 'phones' ] = $d;
		}

		$d = $this->emails()->diff( $client->emails() );
		if ( $d->count() ) {
			$diff[ 'emails' ] = $d;
		}

		$d = $this->orders()->diff( $client->orders() );
		if ( $d->count() ) {
			$diff[ 'orders' ] = $d;
		}

		$d = $this->addresses()->diff( $client->addresses() );
		if ( $d->count() ) {
			$diff[ 'addresses' ] = $d;
		}

		$d = $this->passwords()->diff( $client->passwords() );
		if ( $d->count() ) {
			$diff[ 'passwords' ] = $d;
		}
		$d = $this->passports()->diff( $client->passports() );
		if ( $d->count() ) {
			$diff[ 'passports' ] = $d;
		}

		return $diff;
	}
}
