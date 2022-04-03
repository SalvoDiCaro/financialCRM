<?php

namespace App\Http\Controllers;

use App\Mail\NewUserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use Auth;

class EmailController extends Controller
{
    public function create()
    {

        return view('email');
    }

    public function index()
    {
        $to_name = 'Salvatore Di Caro';
        $to_email = 'salvatoredicaro93@gmail.com';
        $lead = array(
            'name' => 'Cloudways (sender_name)',
            'surname' => 'A test mail',
            'phone' => 'A test mail',
            'email' => 'A test mail',
            'channel' => 'A test mail',
            'current_state' => 'A test mail');

        Mail::send('mails.assignment', ["lead"=>$lead], function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Assegnazione lead');
            $message->from('info@avvera.it', 'Mail di assegnazione lead');
        });

        return 'Email sent Successfully';
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
          'email' => 'required|email',
          'subject' => 'required',
          'content' => 'required',
        ]);

        $data = [
          'subject' => $request->subject,
          'email' => $request->email,
          'content' => $request->content
        ];

        Mail::send('email-template', $data, function($message) use ($data) {
          $message->to($data['email'])
          ->subject($data['subject']);
        });

        return back()->with(['message' => 'Email successfully sent!']);
    }
}
