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

    public function testHello()
    {
        $response = $this->get('/user');
        $content = $response->getBody()->getContents();
        $this->assertSame(200, $response->getStatusCode());
        $rendered = mb_strpos($content, '<p>user!</p>') === false ? false : true;
        $this->assertTrue($rendered);
    }
}