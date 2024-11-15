<?php

namespace Tests\Unit;

use App\Http\Controllers\PostController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_post_requires_title_and_content()
    {
        $data = [
            'title' => '',  // Title is required
            'content' => '' // Content is required
        ];

        $controller = new PostController();
        $request = Request::create('/api/blogs/create', 'POST', $data);

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $controller->createPosts($request);
    }   
}
