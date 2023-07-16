<?php

namespace Librevlad\Leadex\Tests;

use Librevlad\Leadex\Choosers\EmailChooser;
use Librevlad\Leadex\Choosers\StringChooser;
use Librevlad\Leadex\Normalizers\EmailNormalizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Librevlad\Leadex\Tests\TestCase;

class ChoosersTest extends TestCase {
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample() {

        $a = 'vasya@gmail.com';
        $b = 'vasya@gmail.com';

        $o = new EmailChooser( $a, $b, EmailNormalizer::class, false );

        $this->assertTrue( $o->firstIsChosen() );
        $this->assertTrue( $o->firstEqualsSecond() );
        $this->assertEquals( $a, $o->chosen()->finalValue() );

        $o = new EmailChooser( 'beda', 111, EmailNormalizer::class, null );
        $this->assertEquals( $o->chosen()->finalValue(), null );

        $o = new EmailChooser( 'beda@dsa', 111, EmailNormalizer::class, null );
        $this->assertTrue( $o->firstIsChosen() );
    }

    public function testString() {

        $o = new StringChooser( 'Vasilii', 'Vasya' );
        $this->assertTrue( $o->firstIsChosen() );

        $o = new StringChooser( 'ilii', 'Vasya' );
        $this->assertTrue( $o->secondIsChosen() );

        $o = new StringChooser( '', false, null, null );
        // false is chosen because it's at least something
        $this->assertTrue( $o->secondIsChosen() );


    }
}
