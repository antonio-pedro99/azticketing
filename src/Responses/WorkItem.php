<?php

namespace AntonioPedro99\Azticketing\Responses;

class WorkItem
{
    public $id;
    public $title;
    public $description;
    public $metadata;
    public $status;
    public $createdAt;
    public $updatedAt;
    public $url;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->title = $data['fields']['System.Title'];
        $this->description = $data['fields']['System.Description'];
        $this->metadata = $data['fields'];
        $this->status = $data['fields']['System.State'];
        $this->createdAt = $data['fields']['System.CreatedDate'];
        $this->updatedAt = $data['fields']['System.ChangedDate'];
        $this->url = $data['_links']['html']['href'];
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'metadata' => $this->metadata,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'url' => $this->url,
        ];
    }

    public static function fromArray(array $data):self
    {
        return new self($data);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
