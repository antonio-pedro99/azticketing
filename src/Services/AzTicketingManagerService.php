<?php

namespace AntonioPedro99\Azticketing\Services;

use AntonioPedro99\Azticketing\Services\AzTicketingAzureDevOpsService;

class AzTicketingManagerService
{
    protected $azureDevOpsService;

    public function __construct(AzTicketingAzureDevOpsService $azureDevOpsService)
    {
        $this->azureDevOpsService = $azureDevOpsService;
    }

    public function createTicket($title, $description, $metadata)
    {
        return $this->azureDevOpsService->createTicket($title, $description, $metadata);
    }

    public function getTicket($id)
    {
        return $this->azureDevOpsService->getTicket($id);
    }

    public function getTickets($metadata=[])
    {
        return $this->azureDevOpsService->getTickets($metadata);
    }

    public function addComment($id, $comment, $metadata=[])
    {
        return $this->azureDevOpsService->addComment($id, $comment, $metadata);
    }

    public function closeTicket($id, $metadata=[])
    {
        return $this->azureDevOpsService->closeTicket($id, $metadata);
    }

}
