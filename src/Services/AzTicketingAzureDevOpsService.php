<?php

namespace AntonioPedro99\Azticketing\Services;

use GuzzleHttp\Client;

class AzTicketingAzureDevOpsService
{
    protected $client;
    protected $organization;
    protected $project;
    protected $pat;
    protected $webhookSecret;
    protected $areaPath;
    private $baseUrl= 'https://dev.azure.com/';
    private $apiVersion = '7.1-preview.3';

    public function __construct()
    {
        $this->client = new Client();
        $this->organization = config('azticketing.organization');
        $this->project = config('azticketing.project');
        $this->pat = config('azticketing.pat');
        $this->webhookSecret = config('azticketing.webhook_secret');
        $this->areaPath = config('azticketing.area_path');
    }

    private function getHeaders($contentType = 'application/json')
    {
        return [
            'Authorization' => 'Basic ' . base64_encode(":" . $this->pat),
            'Content-Type' => $contentType
        ];
    }

    /**
     * Create a ticket in Azure DevOps
     *
     * @param string $title
     * @param string $description
     * @param array $metadata
     * @return array|string
     */
    public function createTicket($title, $description, $metadata=[])
    {
        $url = "{$this->baseUrl}{$this->organization}/{$this->project}/_apis/wit/workitems/\$issue?api-version={$this->apiVersion}";

        $data = [
            [
                "op" => "add",
                "path" => "/fields/System.Title",
                "value" => $title,
            ],
            [
                "op" => "add",
                "path" => "/fields/System.Description",
                "value" => $description,
            ],
            [
                "op" => "add",
                "path" => "/fields/System.AreaPath",
                "value" => $this->areaPath,
            ]
        ];

        foreach ($metadata as $key => $value) {
            $data[] = [
                "op" => "add",
                "path" => "/fields/{$key}",
                "value" => $value,
            ];
        }

        try {
            $response = $this->client->post($url, [
                'headers' => $this->getHeaders('application/json-patch+json'),
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get a ticket from Azure DevOps
     *
     * @param int $id
     * @return array|string
     */
    public function getTicket($id)
    {
        $url = "{$this->baseUrl}{$this->organization}/{$this->project}/_apis/wit/workitems/{$id}?api-version={$this->apiVersion}";

        try {

            $response = $this->client->get($url, [
                'headers' => $this->getHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get all tickets from Azure DevOps
     * @param $metadata array of metadata to filter the tickets
     * @return array|string
     */
    public function getTickets($metadata=[])
    {
        $url = "{$this->baseUrl}{$this->organization}/{$this->project}/_apis/wit/wiql?api-version=7.1-preview.2";

        // default columns
        $columns = ["[System.Id], [System.Title], [System.State]"];

        // template query
        $query = "SELECT ". implode(", ", $columns). " FROM WorkItems";

        if ($metadata) {
            $query .= " WHERE ";
            foreach ($metadata as $key => $value) {
                // take if the key is not in the columns
                if (!in_array($key, $columns)) {
                    $query .= "[$key] = '$value' AND ";
                }
            }

            // remove the last AND if it exists
            $query = rtrim($query, " AND ");
        }

        try {
            $response = $this->client->post($url, [
                'headers' => $this->getHeaders(),
                'json' => [
                    'query' => $query
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Add comment on a ticket in Azure DevOps
     *
     * @param int $id
     * @param array $data
     * @return array|string
     */
    public function addComment($id, $comment, $metadata=[])
    {
        $url = "{$this->baseUrl}{$this->organization}/{$this->project}/_apis/wit/workitems/{$id}/comments?api-version={$this->apiVersion}";

        $data = [
            "text" => $comment
        ];

        if (!empty($metadata)) {
            $data = array_merge($data, $metadata);
        }

        try {
            $response = $this->client->post($url, [
                'headers' => $this->getHeaders(),
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Close a ticket in Azure DevOps
     *
     * @param int $id
     * @param array $metadata array of metadata to close the ticket
     * @return array|string
     */
    public function closeTicket($id, $metadata=[])
    {
        $url = "{$this->baseUrl}{$this->organization}/{$this->project}/_apis/wit/workitems/{$id}?api-version={$this->apiVersion}";

        $data = [
            [
                "op" => "add",
                "path" => "/fields/System.State",
                "value" => "Closed",
            ]
        ];

        // expand the data array with metadata
        foreach ($metadata as $key => $value) {
            $data[] = [
                "op" => "add",
                "path" => "/fields/{$key}",
                "value" => $value,
            ];
        }

        try {
            $response = $this->client->patch($url, [
                'headers' => $this->getHeaders(),
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
