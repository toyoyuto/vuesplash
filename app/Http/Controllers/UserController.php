<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Log;
use App\Mail\OrderShipped;
use App\Jobs\SendWelcomeMail;

class UserController extends Controller
{
    protected function index()
    {
        // $collection = collect();
        // User::get()->each(function ($user) use($collection) {
        //     $user->phones()->chunk(2, function($phones) use($collection) {
        //         $phones->each(function ($phone) use($collection) {
        //             $collection->push($phone);
        //         });
        //     });
        // });
        // User::chunk(2, function($users) use($collection) {
        //     $users->each(function ($user) use($collection) {
        //         Log::info($user);
        //         $collection->push($user);
        //     });
        // });
        
        $data = User::with('phones.user')->get();
        $data->each(function ($use)  {
            $pp = $use->phones;
            $use->phonesd = $pp;

            
        //     $use->phonesd = $oo;
            // $pp = $phones->user->name;
            
            // $phones->phonesd = $pp;
            
        });
        // $data->each(function ($use)  {

        //     $oo=$use->phones->map(function ($phone){
        //         return $phone->phone;
        //     });
        //     if (count($oo) == 3){
        //         $oo=["3だだ"];
        //     }
        //     $pp = $use->phones->pluck('phone')->toArray();
        //     if(count($pp) == 3) {
        //             $oo="全部";
        //     } else {
        //          $oo=implode(PHP_EOL, $use->phones->pluck('phone')->toArray());
        //     }

            
        //     $use->phonesd = $oo;
            
        // });
        return response()->json(compact('data'), '200');
    }

    protected function send()
    {
        Mail::to(env('TOYO_MAIL_FROM_ADDRESS'))->queue((new OrderShipped())->onQueue('emails'));
        return response()->json('', '200');
    }

    // protected function send()
    // {
    //     SendWelcomeMail::dispatch();
    //     return response()->json('', '200');
    // }
}