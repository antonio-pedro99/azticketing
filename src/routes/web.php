<?php

namespace AntonioPedro99\Azticketing;

use AntonioPedro99\Azticketing\Responses\WorkItem;
use Illuminate\Support\Facades\Route;
use AzTicketingManager;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web'], 'prefix'=>'azticketing'], function () {

    Route::get('/', function () {

        $azTickets = AzTicketingManager::getTickets([
            'Custom.ReportedBy' => 'Angel Duran'
        ]);

        $workItems = $azTickets["workItems"];
        $workItemsWithDetails = [];

        foreach ($workItems as $workItem) {
            $workItemDetails = AzTicketingManager::getTicket($workItem["id"]);
            $workItemsWithDetails[] = WorkItem::fromArray($workItemDetails);
        }

        return view('azticketing::index' , ['tickets' => $workItemsWithDetails]);
    });


    Route::post('/workitem/create', function (Request $request) {

        $title = $request->input('title');
        $description = $request->input('description');
        // $tags = $request->input('tags');

        // $metadata = [
            //'System.Tags' => $tags,
          //  'Custom.ReportedBy' => 'Angel Duran'
        //];

        $az = AzTicketingManager::createTicket($title, $description, []);

        if ($az) {
            return view('azticketing::index' , ['ticket' => $az])->with('success', 'Ticket created');
        } else {
            return view('azticketing::index' , ['error' => 'Error creating ticket'])->with('error', 'Error creating ticket');
        }
    })->name('azticketing.create');

    Route::get('/workitem/{id}', function ($id) {

        $ticket = AzTicketingManager::getTicket($id);

        if ($ticket) {
            $workItem = WorkItem::fromArray($ticket);

            return view('azticketing::index' , ['ticket' => $workItem])->with('success', 'Ticket created');
        } else {
            return view('azticketing::index' , ['error' => 'Error getting ticket'])->with('error', 'Error getting ticket');
        }
    });

    Route::post('/workitem/{id}/addcomment', function ($id, Request $request) {

        $body = $request->input('text');

        $ticket = AzTicketingManager::addComment($id, $body);

        if ($ticket) {
            $workItem = WorkItem::fromArray($ticket);

            return view('azticketing::index' , ['ticket' => $workItem])->with('success', 'Comment added');
        } else {
            return view('azticketing::index' , ['error' => 'Error adding comment'])->with('error', 'Error adding comment');
        }
    });

    Route::get('/workitem/{id}/close', function ($id) {

        $az = AzTicketingManager::closeTicket($id);

        return view('azticketing::index' , ['ticket' => $az]);
    });

    Route::get('/workitem/{id}/close', function ($id) {

        $az = AzTicketingManager::closeTicket($id);

        return view('azticketing::index' , ['ticket' => $az]);
    });

});
