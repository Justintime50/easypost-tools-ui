<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use EasyPost\EasyPost;
use EasyPost\Address;

EasyPost::setApiKey(env('EASYPOST_UNIT_TESTING_API_KEY'));

class AddressTest extends TestCase
{
    /**
     * Test the creation of an address
     *
     * @return void
     */
    public function testCreate()
    {
        $address_params = array(
            "street1" => "388 Townsend St",
            "street2" => "Apt 20",
            "city"    => "San Francisco",
            "state"   => "CA",
            "zip"     => "94107");

        $address = Address::create($address_params);

        $this->assertInstanceOf('\EasyPost\Address', $address);
        $this->assertIsString($address->id);
        $this->assertStringMatchesFormat("adr_%s", $address->id);
        $this->assertNull($address->name);

        return $address;
    }

    /**
     * Test the retrieval of an address
     *
     * @param Address $address
     * @return void
     * @depends testCreate
     */
    public function testRetrieve(Address $address)
    {
        $retrieved_address = Address::retrieve($address->id);

        $this->assertInstanceOf('\EasyPost\Address', $retrieved_address);
        $this->assertEquals($retrieved_address->id, $address->id);
        $this->assertEquals($retrieved_address, $address);

        return $retrieved_address;
    }
}
