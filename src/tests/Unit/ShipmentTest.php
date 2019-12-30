<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use EasyPost\EasyPost;
use EasyPost\Shipment;

EasyPost::setApiKey(env('EASYPOST_UNIT_TESTING_API_KEY'));

class ShipmentTest extends TestCase
{
    /**
     * Test the creation of a Shipment
     *
     * @return void
     */
    public function testCreate()
    {
        $shipment = Shipment::create(
            array(
                "to_address"    => array(
                    "street1" => "388 Townsend St",
                    "street2" => "Apt 20",
                    "city"    => "San Francisco",
                    "state"   => "CA",
                    "zip"     => "94107"),
                "from_address"  => array(
                    "street1" => "388 Townsend St",
                    "street2" => "Apt 20",
                    "city"    => "San Francisco",
                    "state"   => "CA",
                    "zip"     => "94107"),
                "parcel"    => array(
                    "length"     => "10",
                    "width"     => "8",
                    "height"    => "4",
                    "weight"    => "15")
            )
        );

        $this->assertInstanceOf('\EasyPost\Shipment', $shipment);
        $this->assertIsString($shipment->id);
        $this->assertStringMatchesFormat("shp_%s", $shipment->id);

        return $shipment;
    }

    /**
     * Test the retrieval of a Shipment
     *
     * @param Shipment $shipment
     * @return void
     * @depends testCreate
     */
    public function testRetrieve(Shipment $shipment)
    {
        $retrieved_shipment = Shipment::retrieve($shipment->id);

        $this->assertInstanceOf('\EasyPost\Shipment', $retrieved_shipment);
        $this->assertEquals($retrieved_shipment->id, $shipment->id);
        $this->assertEquals($retrieved_shipment, $shipment);

        return $retrieved_shipment;
    }
}
