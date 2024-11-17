<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BlogPostController extends Controller
{

    public function viewAddPost()
    {
        try{

            return view('posts.add-posts');
            
        }catch( \Exception $e ){
            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of view Dashboard :: ", $err);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 401);
        }
    }

    public function createPost( Request $request )
    {
        try{

            $input = $request->all();

            $validation = Validator::make($input, [
                'title' => 'required|string|max:50',
                'content' => 'required|string',
            ]);

            if($validation->fails()){
                return redirect()->back()->with('error', $validation->errors()->first())->withInput();
            }

            $posts = Post::create([
                'title' => $input['title'],
                'content' => $input['content'],
                'author' => Auth::user()->name
            ]);

            if(!$posts){
                return redirect()->back()->with('error', 'Something went wrong.')->withInput();
            }

            return redirect()->route('dashboard')->with('success', 'Post added successfully!');
            
        }catch( \Exception $e ){
            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of view Dashboard :: ", $err);

            return redirect()->back()->with('error', $e->getMessage())->withInput();
          
        }
    }

    public function viewEditPost( $id = '' )
    {
        try{

            if(empty($id)){
                return redirect()->route('dashboard')->with('error', 'Post ID is required.');
            }

            $post = Post::where('id', $id)->first();

            if(!$post){
                return redirect()->route('dashboard')->with('error', 'Invalid Post ID.');
            }           

            return view('posts.edit-post')->with('post', $post);
            
        }catch( \Exception $e ){
            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of view Dashboard :: ", $err);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 401);
        }
    }

    public function updatePost( Request $request )
    {
        try{

            $input = $request->all();

            $validation = Validator::make($input, [
                'id' => 'required|integer',
                'title' => 'required|string|max:50',
                'content' => 'required|string', 
            ]);

            if($validation->fails()){
                return redirect()->back()->with('error', $validation->errors()->first())->withInput();
            }

            $post = Post::where('id', $input['id'])->first();

            if(!$post){
                return redirect()->route('dashboard')->with('error', 'Invalid Post ID.');
            }    

            $posts = Post::where('id', $input['id'])->update([
                'title' => $input['title'],
                'content' => $input['content'],
            ]);

            if(!$posts){
                return redirect()->back()->with('error', 'Something went wrong.')->withInput();
            }

            return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
            
        }catch( \Exception $e ){
            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of view Dashboard :: ", $err);

            return redirect()->back()->with('error', $e->getMessage())->withInput();
          
        }
    }

    public function deletePost( $id = '' )
    {
        try{

            if(empty($id)){
                return redirect()->back()->with('error', 'Post ID is required.');
            }

            $post = Post::where('id', $id)->first();

            if(!$post){
                return redirect()->back()->with('error', 'Invalid Post ID.');
            }
            
            $delete = Post::where('id', $id)->delete();

            if(!$delete){
                return redirect()->back()->with('error', 'Something went wrong.');
            }

            return redirect()->back()->with('success', 'Post deleted successfully');
            
        }catch( \Exception $e ){
            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of view Dashboard :: ", $err);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 401);
        }
    }

}
