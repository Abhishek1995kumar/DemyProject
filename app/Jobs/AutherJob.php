<?php

namespace App\Jobs;

use Throwable;
use Exception;
use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AutherJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $authorApi;
    public function __construct($apiUrl) {
        $this->authorApi = $apiUrl;
        // dd($this->authorApi);
    }

    public function handle() {
        try{
            foreach($this->authorApi['entries'] as $key=>$entry) {
                if(isset($entry['title'])) {
                    $authorDetails = new Author();
                    $authorDetails['title'] = $entry['title'];

                    if(isset($entry['description'])){
                        $authorDetails->description = $entry['description']['value'] ?? NULL;
                    }

                    if(isset($entry['authors'])){
                        $authorIndex = [];
                        foreach($entry['authors'] as $auth) {
                            if(isset($auth['author']['key'])){
                                $authorIndex[] = $auth['author']['key'];
                            }
                        }
                        $authorDetails->author = implode(', ', $authorIndex);
                    }

                    // $authorDetails->save();
                    if(!empty($authorDetails)) {
                        $authorDetails->save();
                    } else {
                        Log::error('Error while inserting data into database');
                    }

                } else {
                    Log::error('Title is not found');
                }
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
