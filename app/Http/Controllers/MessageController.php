<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Events\MessageSend;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function user_list()
    {
        $users = User::latest()
        ->where('id','!=',auth()->user()->id)
        ->get();

        if (!\Request::ajax()) {
            return abort(404);
        }
        return response()->json($users,200);

    }
    public function user_message($id=null)
    {
        if (!\Request::ajax()) {
            return abort(404);
        }
       $user = User::findOrFail($id);
       $messages = $this->message_by_user_id($id);

       return response()->json([
           'messages'=>$messages,
           'user'=>$user
       ]);
    }

    public function send_message(Request $request)
    {
        $messages = Message::create([
            'message'=>$request->message,
            'from'=>auth()->user()->id,
            'to'=>$request->user_id,
            'type'=>0
        ]);

        $messages = Message::create([
            'message'=>$request->message,
            'from'=>auth()->user()->id,
            'to'=>$request->user_id,
            'type'=>1
        ]);

        if (!\Request::ajax()) {
            return abort(404);
        }

        broadcast(new MessageSend($messages));

        return response()->json($messages,201);
    }

    public function delete_single_message($id=null)
    {
        if (!\Request::ajax()) {
            return abort(404);
        }
        Message::findOrFail($id)->delete();
        return response()->json('deleted',200);
    }

    public function delete_total_message($id=null)
    {
        // if (!\Request::ajax()) {
        //     return abort(404);
        // }
        
        $messages = $this->message_by_user_id($id);

        foreach($messages as $value) {
            Message::findOrFail($value->id)->delete();
        }
        return response()->json(' Total Deleted',200);
    }

    public function message_by_user_id($id)
    {
        $messages = Message::where(
            function($q) use($id) {
                $q->where('from',auth()->user()->id);
                $q->where('to',$id);
                $q->where('type',0);
            }
        )
        ->orWhere(
            function($q) use ($id) {
                $q->where('from',$id);
                $q->where('to',auth()->user()->id);
                $q->where('type',1);
            }
        )
        ->with('user') // user function in Message model
        ->get();
        return $messages;
    }
    
    
}
