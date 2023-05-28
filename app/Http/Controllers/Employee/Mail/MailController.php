<?php

namespace App\Http\Controllers\Employee\Mail;

use Google\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Managers\MailManager;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;


class MailController extends Controller
{

  public function index(Request $request, MailManager $mailManager)
  {

    $user = $request->user();
    if (!$user->access_token) {
      return redirect()->route('employee.mails.redirect-to-google');
    }

    $gmail = $mailManager->getMailClient($user);

    // $threads = $gmail->users_threads->listUsersThreads('me');
    $list = $gmail->users_messages->listUsersMessages('me', [
      'q' => 'is:inbox',
      'maxResults' => 1,
    ]);

    $inboxMessage = $mailManager->getMessageList($list, $gmail);


    return  view('content.pages.employee.mail', compact('inboxMessage'));


    // dd($inboxMessage);
  }



  public function getSentMessages(Request $request, MailManager $mailManager)
  {

    $user = $request->user();
    if (!$user->access_token) {
      return redirect()->route('employee.mails.redirect-to-google');
    }

    $gmail = $mailManager->getMailClient($user);

    // $threads = $gmail->users_threads->listUsersThreads('me');
    $list = $gmail->users_messages->listUsersMessages('me', [
      'labelIds' => 'SENT',
      'maxResults' => 20,
    ]);

    $inboxMessage = $mailManager->getMessageList($list, $gmail);
  }

  public function details($id, Request $request, MailManager $mailManager)
  {
    $user = $request->user();


    $gmail = $mailManager->getMailClient($user);
    // $message = $gmail->users_messages->get('me', $id, ['format' => 'full']);
    $mail = $mailManager->getMessage($gmail, $id);

    $html =  view('content.table-helper.mail-view', compact('mail'))->render();



    return response([
      'html' => $html
    ]);
  }



  public function reply(Request $request, MailManager $mailManager)
  {
    $request->validate([
      'mail_id' => 'string|required',
      'message' => 'required|string|max:1000'
    ]);


    // return $request->all();


    $user = $request->user();


    $gmail = $mailManager->getMailClient($user);




    $mailManager->replyToEmailById($gmail, $request->mail_id, 'Test from mail manager', $request->message);

    return response([
      'status' => 'success',
      'message' => 'reply sent successfully'
    ]);
  }


  public function sendMail(Request $request, MailManager $mailManager)
  {
    $request->validate([
      'send_to' => 'required|email|max:255',
      'subject' => 'nullable|string|max:1000',
      'body' => 'required|string|max:3000',
    ]);

    $user = $request->user();
    if (!$user->access_token) {
      return redirect()->route('employee.mails.redirect-to-google');
    }

    $gmail = $mailManager->getMailClient($user);



    $userId = 'me';
    $toEmail = 'recipient@example.com';
    $subject = 'Email Subject';
    $message = 'Hello, This is a test email!';

    $email = new Google_Service_Gmail_Message();
    $email->setRaw($this->createRawMessage($request->send_to, $request->subject, $request->message));

    $sentEmail = $gmail->users_messages->send('me', $email);

    return response()->json([
      'status' => 'success',
      'message' => 'Email sent successfully'
    ]);
  }




  private function createRawMessage($toEmail, $subject, $message)
  {
    $email = 'From: ' . auth()->user()->email . "\r\n";
    $email .= 'To: ' . $toEmail . "\r\n";
    $email .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
    $email .= 'MIME-Version: 1.0' . "\r\n";
    $email .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
    $email .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
    $email .= quoted_printable_encode($message);


    return  rtrim(strtr(base64_encode($email), '+/', '-_'), '=');
  }














  public function redirectToGoogle()
  {
    $client = new Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
    $client->addScope('https://www.googleapis.com/auth/gmail.readonly');
    $client->addScope(Google_Service_Gmail::GMAIL_SEND);
    $client->setState('');

    // dd($client->createAuthUrl());
    return redirect($client->createAuthUrl());
  }

  public function handleGoogleCallback(Request $request)
  {
    $client = new Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
    $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));
    $client->setAccessToken($token['access_token']);

    // Store the access token in the session or database for later use
    session(['google_access_token' => $token['access_token']]);

    $user = $request->user();
    $user->access_token = $token['access_token'];
    $user->save();






    return redirect()->route('employee.mails.index');
  }
}
