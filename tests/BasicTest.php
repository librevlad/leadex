<?php

namespace Librevlad\Leadex\Tests;

use Librevlad\Leadex\DTO\Client;
use Librevlad\Leadex\DTO\Fio;
use Librevlad\Leadex\DTO\Phone;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase {

	public function testBasicApi() {
		//        $this->assertEquals(1,1);
		$nameStats = [];
		//		die("ASDASDASDASD");
		echo 'file ' . PHP_EOL;

		$names = array_map( 'trim', file( __DIR__ . '/amo1k.txt' ) );

		echo 'map ' . PHP_EOL;
		$names = array_slice( $names, 0, 1000 );

		echo 'go ' . PHP_EOL;

		foreach ( $names as $name ) {
			$person = new Client();
			$ph     = new Fio( $name );
			$person->fios()->add( $ph );
			$fn = $person->fios()->items()->first()?->get( 'first_name' );
			echo $name . ' [--] ' . $fn . PHP_EOL;
			if ( ! isset( $nameStats [ $fn ] ) ) {
				$nameStats[ $fn ] = 0;
			}
			$nameStats[ $fn ] ++;
		}

		asort( $nameStats );

		var_dump( $nameStats );

	}

}
