<?php

namespace Brackets\AdminListing\Tests\Feature\AdminListing;

use Brackets\AdminListing\AdminListing;
use Brackets\AdminListing\Exceptions\NotAModelClassException;
use Brackets\AdminListing\Tests\TestCase;

class ExceptionsTest extends TestCase
{
    /** @test */
    public function creating_listing_for_a_class_that_is_not_a_model_should_lead_to_an_exception()
    {
        try {
            AdminListing::create(static::class);
        } catch (NotAModelClassException $e) {
            $this->assertTrue(true);
            return ;
        }

        $this->fail('AdminListing should fail when trying to build for a non Model class');
    }

    /** @test */
    public function creating_listing_for_an_integer_class_should_lead_to_an_exception()
    {
        try {
            AdminListing::create(10);
        } catch (NotAModelClassException $e) {
            $this->assertTrue(true);
            return ;
        }

        $this->fail('AdminListing should fail when trying to build for a non Model class');
    }

    /** @test */
    public function creating_listing_for_a_non_class_string_should_lead_to_an_exception()
    {
        try {
            AdminListing::create("Some string that is definitely not a class name");

            // this time we are not checking a NotAModelClassException exception, because it is going to fail a bit earlier
        } catch (\Exception $e) {
            $this->assertTrue(true);
            return ;
        }

        $this->fail('AdminListing should fail when trying to build for a non Model class');
    }
}
