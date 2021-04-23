<?php

namespace Brackets\AdminListing\Tests\Feature\AdminListing;

use Brackets\AdminListing\Tests\TestCase;

class BasicStuffTest extends TestCase
{
    /** @test */
    public function listing_should_return_whole_collection_when_nothing_was_set()
    {
        $result = $this->listing
            ->get();

        $this->assertCount(10, $result);
        $model = $result->first();
        $this->assertArrayHasKey('id', $model);
        $this->assertArrayHasKey('name', $model);
        $this->assertArrayHasKey('color', $model);
        $this->assertArrayHasKey('number', $model);
        $this->assertArrayHasKey('published_at', $model);
    }

    /** @test */
    public function listing_ability_to_specify_columns_to_filter()
    {
        $result = $this->listing
            ->get(['name', 'color']);

        $this->assertCount(10, $result);
        $model = $result->first();
        $this->assertArrayNotHasKey('id', $model);
        $this->assertArrayHasKey('name', $model);
        $this->assertArrayHasKey('color', $model);
        $this->assertArrayNotHasKey('number', $model);
        $this->assertArrayNotHasKey('published_at', $model);
    }

    /** @test */
    public function it_should_be_possible_to_run_same_query_twice()
    {
        $this->listing
            ->get();

        $result = $this->listing
            ->get();

        $this->assertCount(10, $result);
        $model = $result->first();
        $this->assertArrayHasKey('id', $model);
        $this->assertArrayHasKey('name', $model);
        $this->assertArrayHasKey('color', $model);
        $this->assertArrayHasKey('number', $model);
        $this->assertArrayHasKey('published_at', $model);
    }
}
