<?php

namespace Tests\Feature;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    public function testSendMessage()
    {
        $response = $this->json('POST', 'api/v1/add-message', ['content' => 'test content']);

        $response
            ->assertStatus(200)
            ->assertJson(['success' => 'You Email has been send successfully']);
    }

    public function testStoreToDatabase()
    {
        Message::factory()->create();
        $this->assertDatabaseHas('messages', [
            'content' => 'test content'
        ]);
    }

    public function testDeleteFromDatabase()
    {
        Message::where('content', 'test content')->delete();
        $this->assertDatabaseMissing('messages', [
            'content' => 'test content'
        ]);
    }

    public function testErrorResponse()
    {
        $response = $this->json('POST', 'api/v1/add-message', ['content' => '']);

        $response
            ->assertStatus(400)
            ->assertJson(['content' => [
                "Content is required"
            ]]);
    }
}
