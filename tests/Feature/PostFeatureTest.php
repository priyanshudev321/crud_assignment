<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostFeatureTest extends TestCase
{

    public function test_create_post()
    {
        $response = $this->withoutMiddleware()->postJson('/api/blogs/create', [
            'title' => 'New Post',
            'content' => 'This is a new post.',
            'author' => 'Admin',
        ]);
    
        $response->assertStatus(200)
                 ->assertJson([
                    'status' => true,
                    'message' => 'Post Created Successfully.',
                 ]);
    }
    
    public function test_update_post()
    {
        $post = Post::create([
            'title' => 'Old Post Title',
            'content' => 'This is the old content.',
            'author' => 'Admin',
        ]);
    
        $updatedData = [
            'id' => $post->id, 
            'title' => 'Updated Post Title',
            'content' => 'This is the updated content.',
            'author' => 'Admin Updated',
        ];
    
        $response = $this->withoutMiddleware()->postJson('/api/blogs/update', $updatedData);
    
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Post updated successfully.',
                 ]);
    
    }
}
