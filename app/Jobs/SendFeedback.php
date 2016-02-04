<?php

namespace StudentInfo\Jobs;

use GuzzleHttp\Client;
use Illuminate\Contracts\Bus\SelfHandling;

class SendFeedback extends Job implements SelfHandling
{
    /**
     * @var String
     */
    protected $feedback;

    /**
     * Create a new job instance.
     *
     * @param $feedback
     */
    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        $client = new Client();

        $client->request('POST', 'https://hooks.slack.com/services/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', [
            'json' => [
                'text' => $this->feedback,
            ],
        ]);
    }
}
