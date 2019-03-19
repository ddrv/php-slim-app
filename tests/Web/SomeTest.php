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

    public function testNotFound()
    {
        $response = $this->get('/not/found');
        $this->assertSame(404, $response->getStatusCode());
    }

    public function testNotAllowed()
    {
        $response = $this->post('/');
        $this->assertSame(405, $response->getStatusCode());
        $this->assertArraySubset(['GET'], $response->getHeader('allow'));
    }
}