<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotifController extends Controller
{
    public  function  getMynotifs(){
        $notifications=Notification::orderBy("created_at",'desc')->get();
        return response()->json($notifications, 200);
    }
    public  function  seeNotif(){
        $notifications=Notification::where('status',0)->get();
        foreach ($notifications as $notif){
            $notif->status=1;
            $notif->save();
        }
        return response()->json($notifications, 200);
    }
}
