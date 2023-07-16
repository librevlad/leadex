<?php

namespace Librevlad\Leadex\Tests;

use Librevlad\Leadex\Normalizers\EmailNormalizer;
use Librevlad\Leadex\Normalizers\Normalizer;
use Librevlad\Leadex\Normalizers\PhoneNormalizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Librevlad\Leadex\Tests\TestCase;

class NormalizersTest extends TestCase {

    /**
     * @test
     */
    public function it_normalizes_valid_email() {

        $v = 'vasya@mail.zu';
        $o = new EmailNormalizer( $v );
        $this->assertTrue( $o->originalIsValid() );
        $this->assertTrue( $o->originalIsNormalized() );
        $this->assertTrue( $o->normalizedIsValid() );

        $this->assertEquals( $v, $o->getOriginal() );
        $this->assertEquals( $v, $o->getNormalized() );
        $this->assertEquals( $v, $o->finalValue() );

    }

    /**
     * @test
     */
    public function it_normalizes_invalid_email() {

        $v = 'vasya[at]mail.zu';
        $o = new EmailNormalizer( $v );

        $this->assertFalse( $o->originalIsValid() );
        $this->assertFalse( $o->normalizedIsValid() );

        $this->assertTrue( $o->originalIsNormalized() );

        $this->assertEquals( $v, $o->getOriginal() );
        $this->assertEquals( $v, $o->getNormalized() );
        $this->assertNull( $o->finalValue() );
    }

    /**
     * @test
     */
    public function it_normalizes_null() {

        $v = null;
        $o = new EmailNormalizer( $v, 'something' );

        $this->assertFalse( $o->originalIsValid() );
        $this->assertFalse( $o->normalizedIsValid() );

        //        $this->assertTrue( $o->originalIsNormalized() );

        $this->assertEquals( $v, $o->getOriginal() );
        $this->assertEquals( $v, $o->getNormalized() );
        $this->assertEquals( 'something', $o->finalValue() );
    }

    /**
     * @test
     */
    public function it_normalizes_empty_string() {

        $v = '';
        $o = new EmailNormalizer( $v );

        $this->assertFalse( $o->originalIsValid() );
        $this->assertFalse( $o->normalizedIsValid() );

//	    $this->assertTrue( $o->originalIsNormalized() );
	    $this->assertNull( $o->getNormalized() );
	    $this->assertNull( $o->finalValue() );
//
//        $this->assertEquals( $v, $o->getOriginal() );
//        $this->assertEquals( $v, $o->getNormalized() );
//        $this->assertNull( $o->finalValue() );
    }

    /**
     * @test
     */
    public function it_normalizes_phones() {
        $v = 79001234567;
        $o = new PhoneNormalizer( $v );
	    $this->assertTrue( $o->originalIsValid() );
	    // 1234 is invalid!
	    $this->assertNull( $o->getNormalized() );

	    $v = 79001244567;
	    $o = new PhoneNormalizer( $v );
	    $this->assertTrue( $o->originalIsValid() );

	    //        var_dump( $v,$o->getNormalized() ); die();
        $this->assertTrue( $o->originalIsNormalized() );
        $this->assertTrue( $o->normalizedIsValid() );

        $this->assertEquals( $v, $o->getOriginal() );
        $this->assertEquals( $v, $o->getNormalized() );
        $this->assertEquals( $v, $o->finalValue() );

        $v = '9001244567';
        $o = new PhoneNormalizer( $v );
        $this->assertFalse( $o->originalIsValid() );

        $this->assertFalse( $o->originalIsNormalized() );
        $this->assertTrue( $o->normalizedIsValid() );

        $this->assertEquals( $v, $o->getOriginal() );
        $this->assertEquals( 79001244567, $o->getNormalized() );
        $this->assertTrue( $o->normalizedIsFinalValue() );

        $v = '8(90-01)24-45-67';
        $o = new PhoneNormalizer( $v );
        $this->assertFalse( $o->originalIsValid() );

        $this->assertFalse( $o->originalIsNormalized() );
        $this->assertTrue( $o->normalizedIsValid() );

        $this->assertEquals( $v, $o->getOriginal() );
        $this->assertEquals( 79001244567, $o->getNormalized() );
        $this->assertTrue( $o->normalizedIsFinalValue() );

        $v = '79ds.aasd';
        $o = new PhoneNormalizer( $v );
        $this->assertFalse( $o->originalIsValid() );
        $this->assertNull( $o->finalValue() );

    }

}
