<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class playground extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:playground';

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
        $client = new \GuzzleHttp\Client();
            // Log::info($this->record->id);
            $client->request('POST', 'http://127.0.0.1:5500/post-face', [
                // form params as body
                'multipart' => [
                    [
                        'name'     => 'label',
                        'contents' => '',
                    ],
                    [
                        'name'     => 'fileUrl',
                        'contents' => '',
                    ],
                ],
            ]);
    }
}
