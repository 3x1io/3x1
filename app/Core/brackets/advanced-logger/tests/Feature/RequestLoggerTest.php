<?php

namespace Brackets\AdvancedLogger\Test\Feature;

use Brackets\AdvancedLogger\Test\TestCase;

class RequestLoggerTest extends TestCase
{

    /** @test */
    public function request_is_logged_in_file()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $this->assertStringContainsString('127.0.0.1', file_get_contents($this->getRequestLogFileName()));
        $this->assertStringContainsString(' GET http://localhost', file_get_contents($this->getRequestLogFileName()));
    }

    /** @test */
    public function excluded_path_is_not_logged()
    {
        $response = $this->get('/excluded');
        $response->assertStatus(200);
        $this->assertFileDoesNotExist($this->getRequestLogFileName());
        //We are deleting request file, so there should not be a file
//        $this->assertNotContains(' GET http://localhost/excluded', file_get_contents($this->getRequestLogFileName()));
    }
}
