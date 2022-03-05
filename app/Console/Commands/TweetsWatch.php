<?php

namespace App\Console\Commands;

use App\Models\LastTweet;
use App\Models\Tweet;
use App\Models\Twitter;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TweetsWatch extends Command
{

    private $embeddedUrl = "https://publish.twitter.com/oembed?url=";
    private $apiBase = "https://api.twitter.com/2/users/";
    private $query = "/tweets?tweet.fields=created_at,text,entities";
    private $token = "AAAAAAAAAAAAAAAAAAAAAJJqZwEAAAAAOPkbxfJ0i%2B3KdZTIDu4sczx8zyo%3DKwbetboxznrLBpPaHuTRAA8dhpp7tf1P8gq3DVXvqPLWN992ht";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweets:watch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and save new tweets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Cron is working fine!");
        $this->getTweets();
        return 0;
    }

    private function getTweets() {
        $time = LastTweet::first();
        if($time == null) {
            $time = new LastTweet;
        }
        $time->created_at = Carbon::now();
        $time->save();
        foreach (Twitter::all() as $twitter) {
            DB::statement('CREATE TABLE if not exists ' . $twitter->db . ' (id INT AUTO_INCREMENT PRIMARY KEY, status VARCHAR(100) NOT NULL, html TEXT,  text TEXT, posted DATETIME, CONSTRAINT status UNIQUE (status))');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token, //App::get('TOKEN'),
            ])->get($this->apiBase . $twitter->nick . $this->query);
            $decodedAsArray = json_decode($response, true);
            $innerPost = $decodedAsArray['data'];
            foreach($innerPost as $el) {
                $tweet = new Tweet;
                $tweet->setTable($twitter->db);
                if($tweet->where('status', $el['id'])->first()) {
                    $update = true;
                } else {
                    $update = false;
                }
                $tweet->posted = $el['created_at'];
                $tweet->status = $el['id'];
                $text = $el['text'];
                if(isset($el['entities'])) {
                    foreach ($el['entities'] as $key => $entity) {
                        if ($key == 'urls') {
                            str_replace($entity[0]['url'], '<a href="' . $entity[0]['expanded_url'] . '">' . $entity[0]['display_url'] . '</a>', $text);
                        }
                    }
                }
                $text = nl2br($text);


                $tweet->text = $text;
                $tweet->html = $this->getEmbedded($twitter->url . 'status/' . $tweet->status);
                if($update) {
                    $tweet->update();
                } else {
                    $tweet->save();
                }
            }

        }
    }

    private function getEmbedded($url) {
        $response = Http::get($this->embeddedUrl . $url);
        $decoded = json_decode($response);
        return $decoded->html;
    }
}
