<?php

namespace App\Jobs;

use Exception;
use Throwable;
use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Exists;

class AuthorDetailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details; // this is my global variable which i used anywhere in the AuthorDetailsJob class, but here is null because I don't initialized here
    public function __construct($authorData) {
        $this->details = $authorData;
        // dd($this->details);
    }


    public function handle() {
        try{
            $detailsAuthor = $this->details;
            $countLoop = 0;
            if(!empty($detailsAuthor)) {
                foreach($detailsAuthor['entries'] as $key => $value) {
                    if(isset($value['title'])){ 
                        $multipleAuthorDetailsSave = new Author();
                        $multipleAuthorDetailsSave->title = $value['title'];

                        if(isset($value['created'])) {
                            if(isset($value['created'])) {
                                $multipleAuthorDetailsSave->created = $value['created']['value'] ?? NULL;
                            }
                        }
                        
                        if(isset($value['description'])) {
                            if(!empty($value['description']['value'])) {
                                $multipleAuthorDetailsSave->description = $value['description']['value'] ?? NULL;
                            } elseif(!empty($value['description'])) {
                                $multipleAuthorDetailsSave->description = $value['description'] ?? NULL;
                            }
                        }
                        
                        if(isset($value['authors'])){
                            $authorArray = [];
                            foreach($value['authors'] as $author){
                                if(isset($author['author'])){
                                    if(isset($author['author']['key'])){
                                        $authorArray[] = $author['author']['key'];
                                    }
                                }
                            }
                            $multipleAuthorDetailsSave->author = implode(',', $authorArray);
                        }
                        
                        $alreadAuthorExists = Author::where('created', $multipleAuthorDetailsSave->created)->first();

                        if($alreadAuthorExists) {
                            Log::error("Could not save multiple author details");
                            
                        } else {
                            $multipleAuthorDetailsSave->save();
                        }
                    }
                }
            } else {
                Log::error('Error while inserting data into database');
            }

        } catch(Exception $e){
            Log::info('Add author details '. $e->getMessage());
        }
    }
}
