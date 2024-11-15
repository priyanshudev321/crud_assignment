<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWeeklySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:weekly-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("yes here executed");
        $oneWeekAgo = date('Y-m-d H:i:s', strtotime('-1 week'));

        $posts = Post::where('created_at', '>=', $oneWeekAgo)->get();
    
        $postSummaries = $posts->map(function ($post) {
            return date('Y-m-d', strtotime($post->created_at)) . ': ' . $post->title;
        })->implode("\n");
    
        Mail::raw("Weekly Summary:\n" . $postSummaries, function ($message) {
            $message->to('user@example.com')
                    ->subject('Weekly Post Summary');
        });
    }
}
