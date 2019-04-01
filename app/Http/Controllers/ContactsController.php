<?php

namespace App\Http\Controllers;
use App\http\Requests;  
use Illuminate\Http\Request;
use App\Service;
use Mail;


class ContactsController extends Controller
{
    public function getContactForm(){
        $services = Service::all();

        //return view('');
    }

    public function postContact(Request $request){
        $this->validate($request,[
            'email' => 'required|email',
            'subject' => 'min:3',
            'phone' => 'required',
            'body' => 'string',
            'linkin' => 'nullable',
            'service' => 'nullable',
            'name' => 'required'
        ]);

        $data = [
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'bodyMessage' => $request->body,
            'linkin' => $request->linkin,
            'service' => $request->service,
            'name' => $request->name
        ];

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('solomoreal@yahoo.com');
            $message->subject($data['subject']);
        });
    }
}
