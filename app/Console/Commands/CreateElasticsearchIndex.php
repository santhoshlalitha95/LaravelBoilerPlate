<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateElasticsearchIndex extends Command
{
    protected $signature = 'elasticsearch:create-index';

    protected $description = 'Create an Elasticsearch index for products';

    public function handle(): void
    {
        $client = app('Elasticsearch');

        $params = [
            'index' => 'products',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'name' => [
                            'type' => 'text',
                        ],
                        'price' => [
                            'type' => 'float',
                        ],
                        'description' => [
                            'type' => 'text',
                        ],
                    ],
                ],
            ],
        ];

        $response = $client->indices()->create($params);

        $this->info('Index created: '.json_encode($response));
    }
}
