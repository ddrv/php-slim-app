<?php

namespace Tests\App\Web;

use Tests\App\TestWebCase;

class SomeTest extends TestWebCase
{
    public function testMain()
    {
        $response = $this->get('/');
        $this->assertSame(200, $response->getStatusCode());
    }
}