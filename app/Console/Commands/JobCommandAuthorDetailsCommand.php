<?php

namespace App\Console\Commands;

use Exception;
use App\Jobs\AuthorDetailJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class JobCommandAuthorDetailsCommand extends Command {
    protected $signature = 'command:testApi';

    protected $description = 'Command description';

    public function handle() {
        try{
            $authorApi = Http::get('https://openlibrary.org/authors/OL23919A/works.json');
            if($authorApi->successful()) {
                $responseArray = $authorApi->json();
                AuthorDetailJob::dispatch($responseArray)->onQueue('default');
            }
        } catch(Exception $e) {
            $e->getMessage();
        }
    }


}
