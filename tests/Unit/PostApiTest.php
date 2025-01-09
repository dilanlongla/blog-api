<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PostApiTest extends TestCase
{
    public function test_post_creation()
    {
        $response = $this->post('/api/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.'
        ]);

        $response->assertStatus(201);
    }
}
