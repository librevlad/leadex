<?php


namespace Librevlad\Leadex\Tests;

use Librevlad\Leadex\ClientData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientDataTest extends TestCase {
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testImport() {

        $d = new ClientData();
        $d = $d->setFio( 'Masha Вася Петя' );
        $d = $d->setFio( 'Иванов Петрович Сергей' );
        $this->assertEquals( 'Сергей', $d->get( 'fio.first_name' ) );
        $this->assertEquals( 'male', $d->get( 'fio.gender' ) );

        $d->setBirthday( '1990-10-10' );
        $this->assertEquals( '1990-10-10', $d->get( 'birthday' ) );

        $d->setBirthday( 'asd-10-10' );
        $this->assertNull( $d->get( 'birthday' ) );

        $d->setCity( 'москва' );
        $this->assertEquals( 'Москва', $d->get( 'city' ) );

        $d->setCity( 'ы' );
        $this->assertNull( $d->get( 'city' ) );

        $d->addSource( 12 );
        $d->addSource( 1 );
        $d->addSource( 1 );
        $this->assertCount( 2, $d->get( 'sources' ) );

        $d->addPhone( 'dsad' );
        $this->assertCount( 0, $d->get( 'phones' ) );
        $d->addPhone( '7900111-22-33' );
        $d->addPhone( '7900111-22-33' );
        $this->assertCount( 1, $d->get( 'phones' ) );
        $d->addPhone( 79001112243 );
        $d->addPhone( [ 'phone' => 79001112244, 'alive' => false ] );
        $this->assertCount( 3, $d->get( 'phones' ) );
        $this->assertFalse( $d->get( 'phones.79001112244.alive' ) );


        $d->addEmail( 'dsa' );
        $this->assertCount( 0, $d->get( 'emails' ) );
        $d->addEmail( 'dsa@mail.ru' );
        $d->addEmail( 'dsa@mail.ru' );
        $this->assertCount( 1, $d->get( 'emails' ) );

        $d->addAddress( 's' );
        $this->assertCount( 0, $d->get( 'addresses' ) );

        $d->addAddress( [ 'street_address' => 'ленина 50', 'city' => 'москва' ] );
        $this->assertCount( 1, $d->get( 'addresses' ) );
        $this->assertEquals( 'Москва', $d->get( 'addresses' )[ 'Ленина 50' ][ 'city' ] );

        $d->addOrder( [ 'items' => 'iPhone', 'amount' => 1000 ] );
        $d->addOrder( [ 'items' => 'iPhone', 'amount' => 100 ] );
        $d->addOrder( [ 'items' => 'i', 'amount' => 100 ] );
        $this->assertCount( 1, $d->get( 'orders' ) );


    }
}
