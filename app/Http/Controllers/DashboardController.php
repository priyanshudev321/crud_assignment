<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function viewDashboard( Request $request )
    {
        try{

            $posts = Post::select('id', 'title', 'content', 'author', 'created_at')
                    ->whereNull('deleted_at')
                    ->orderBy('created_at', 'desc')->paginate(10);

            return view('dashboard')->with('posts', $posts);

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
