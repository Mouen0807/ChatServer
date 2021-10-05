<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use App\Events\MessageRequest;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    
    /**
     * Store a newly created message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageService $messageService, Request $request)
    {
        return $messageService->new($request);
    }

    /**
     * Display the specified message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MessageService $messageService, $id)
    {
        return $messageService->getOne($id);
    }
    
    /**
     * find all messages in storage by serviceId, receiverId and senderId.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAll(MessageService $messageService, Request $request)
    {
        return $messageService->getAll($request);
    }


    /**
     * Update the specified message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MessageService $messageService, Request $request, $id)
    {
        return $messageService->update($request, $id);
    }

    /**
     * Remove the specified message from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageService $messageService, $id)
    {
        return $messageService->delete($id);
    }


    
}
