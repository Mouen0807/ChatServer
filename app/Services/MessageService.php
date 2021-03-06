<?php

namespace App\Services;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Events\Queue\SerializesModels;
use App\Events\MessageEvent;

class MessageService
{
    public function __construct()
    {}

    public function new(Request $request){
        $data = $request->all();
        $receiverId = $data['receiverId'];
        $senderId = $data['senderId'];
        $servId = $data['serviceId'];
        if ($receiverId==null or $senderId==null or $servId==null) {
            return [
                "status" => "any",
                "message" => "no user or service found"
            ];
        }
        $receiverExists = ( Http::get('https://gadgetsdeals.co.za/api/user/getOne/' . $receiverId)['data']!=null ) ? true : False; 
        $senderExists   = ( Http::get('https://gadgetsdeals.co.za/api/user/getOne/' . $senderId)['data']!=null ) ? true : False;
        $servExists     = ( Http::get('https://gadgetsdeals.co.za/api/service/getOne/' . $servId)['data']!=null ) ? true : False;
        
        if($servExists && $receiverExists && $servExists){
            $res = Message::create($data);
            event(new \App\Events\MessageEvent($res));// broadcast of event on private channel        
            return [
                "status" => "success",
                "message" => "saved success",
                "data" => $res
            ];
        }
        else{
             return [
                "status" =>  "Denied",
                "message" => "You're not allowed to post message",
            ];
        }

        
    }

    public function getOne($id)
    {
        $res = Message::find($id);
        return [
            "status" => "success",
            "message" => "retried success",
            "data" => $res
        ];
    }

    public function getAll(Request $request)
    {
        $data = $request->all();
        $receiver = $data['receiverId'];
        $sender = $data['senderId'];
        $serv = $data['serviceId'];
        if ($receiver==null or $sender==null or $serv==null) {
            return [
                "status" => "any",
                "message" => "no user or service found"
            ];
        }
        $res = Message::query()->where('serviceId', '=', $serv)
                               ->where('senderId', '=', $sender)
                               ->where('receiverId', '=', $receiver)
                               ->get();
        return $res;
    }

    public function update(Request $request, $id)
    {
        $bid = Message::find($id);
        $bid->update($request->all());
        return [
            "status" => "success",
            "message" => "updated successfully",
            "data" => $bid
        ];
    }

    public function delete($id)
    {
        $res = Message::destroy($id);
        if ($res==1) {
            return [
                "status" => "success",
                "message" => "deleted successfully"
            ];
        } elseif ($res==0) {
            return [
                "status" => "any",
                "message" => "no Message found"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "an error occured"
            ];
        }
    }
}