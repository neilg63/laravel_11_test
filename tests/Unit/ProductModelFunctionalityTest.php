<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductModelFunctionalityTest extends TestCase
{
    /**
     * Test the SKU is correct and the currency has been cast to upper case
     */
    public function test_currency_is_uppercase()
    {
        // create a new product instance
        $data = [
            'sku' => 'WCH987654321',
            'name' => 'Wooden chair',
            'description' => 'Lorem ipsum',
            'currency' => 'euro',
            'price' => 15000,
        ];
        $product = new Product($data);
 
        // check the SKU
        $this->assertEquals($data['sku'], $product->sku);
        // check currency is 3 capital letters
        $this->assertEquals('EUR', $product->currency);
        
    }

    /**
     * Test that product cannot be saved without a price
     */
    public function test_product_without_a_price_is_invalid()
    {
        // create a new product instance
        $data = [
            'sku' => 'DCH987654321',
            'name' => 'Dining chair',
            'description' => 'Lorem ipsum',
            'currency' => 'gbp',
        ];
        $product = new Product($data);
        $saved = $product->save();
        $this->assertIsNotNumeric($product->price);
        $this->assertFalse($saved);
        
    }
}
