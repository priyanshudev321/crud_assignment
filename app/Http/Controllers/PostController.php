<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{

    public function createPosts( Request $request )
    {
        try{

            $input = $request->all();
            Log::info( "All inputs of creating posts :: ", $input );

            $validation = Validator::make($input, [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'nullable|string|max:255'
            ]);

            if($validation->fails()){
                // throw new \Exception( $validation->errors()->first() );
                throw new ValidationException($validation);
            }

            $create = Post::create([
                'title' => $input['title'],
                'content' => $input['content'],
                'author' => Auth::user()->name,
            ]);

            if(!$create){
                throw new \Exception( ' Something went wrong! ' );
            }

            event(new PostCreated($create));

            return response()->json([
                'status' => true,
                'message' => 'Post Created Successfully.'
            ]);

        }catch( \Exception $e ){

            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of creating posts :: ", $err);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 401);

        }
    }

    public function postsList( Request $request )
    {
        try{

            $posts = Post::whereNull('deleted_at');
            
            if(isset($request->search)){
                $posts = $posts->where( 'title', 'like' , '%'. $request->search .'%' )
                            ->orWhere(  'content', 'like' , '%'. $request->search .'%' )
                            ->orWhere(  'author', 'like' , '%'. $request->search .'%' );
            }

            $posts = $posts->orderBy('created_at', 'desc')->paginate(10);

            $data = [];
            foreach( $posts as $val ){
                $data[] = [
                    'id' => $val['id'],
                    'title' => $val['title'],
                    'content' => $val['content'],
                    'author' => $val['author'],
                    'created_at' => $val['created_at'] ? date('d M Y h:i A', strtotime($val['created_at'])) : ''
                ];
            }           

            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => 'Posts List.'
            ]);

        }catch( \Exception $e ){

            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of posts list :: ", $err);

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
            Log::info( "All inputs of creating posts :: ", $input );

            $validation = Validator::make($input, [
                'id' => 'required|integer',
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'nullable|string|max:255'
            ]);

            if($validation->fails()){
                throw new \Exception( $validation->errors()->first() );
            }
            
            $id = $input['id'];
            $post = Post::find($id);

            if(!$post){
                throw new \Exception( ' Invalid Post ID. ' );
            }

            $update = Post::where('id', $id)->update([
                'title' => $input['title'],
                'content' => $input['content'],
                'author' => $input['author'],
            ]);

            if(!$update){
                throw new \Exception( " Something went wrong! " );
            }

            return response()->json([
                'status' => true,
                'message' => 'Post updated successfully.'
            ]);

        }catch( \Exception $e ){

            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of updating post :: ", $err);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 401);

        }
    }
    
    public function postDetails( $id = '' )
    {
        try{
            
            if(empty($id)){
                throw new \Exception( 'Post ID is required.' );
            }

            $post = Post::where('id', $id)->first();

            if(!$post){
                throw new \Exception( " Post ID is invalid. " );
            }

            $data = [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'author' => $post->author,
                'created_at' => $post->created_at ? date('d M Y h:i A', strtotime($post->created_at)) : ''
            ];

            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => 'Post Details.'
            ]);

        }catch( \Exception $e ){

            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of updating post :: ", $err);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 401);

        }
    }
    
    public function deletePost( $id = '' )
    {
        try{
            
            if(empty($id)){
                throw new \Exception( 'Post ID is required.' );
            }

            $post = Post::find($id);

            if(!$post){
                throw new \Exception( " Post ID is invalid. " );
            }

            $delete = Post::where('id', $id)->delete();

            if(!$delete){
                throw new \Exception( " Something went wrong! " );
            }

            return response()->json([
                'status' => true,
                'message' => 'Post deleted successfully.'
            ]);

        }catch( \Exception $e ){

            $err = [
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'file' => __FILE__
            ];

            Log::error("All Exception of updating post :: ", $err);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 401);

        }
    }

}
