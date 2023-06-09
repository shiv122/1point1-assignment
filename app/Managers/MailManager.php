<?php

namespace App\Managers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Google\Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;

class MailManager
{


  public function getMessageList($list, $gmail)
  {
    $messageList = $list->getMessages();
    $inboxMessage = [];

    foreach ($messageList as $mlist) {
      $inboxMessage[] = $this->getMessage($gmail, $mlist->id);
    }

    return $inboxMessage;
  }


  public function getMailClient(User $user): Google_Service_Gmail
  {




    $client = new Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri('http://127.0.0.1:9000/employee/mails/google/callback');


    $client->setAccessToken($user->access_token);

    $threadMessages = [];
    $gmail = new Google_Service_Gmail($client);

    return $gmail;
  }


  public function getMessage($gmail, $id)
  {
    $optParamsGet2['format'] = 'full';
    $message = $gmail->users_messages->get('me', $id, $optParamsGet2);
    $message_id = $id;
    $headers = $message->getPayload()->getHeaders();
    $snippet = $message->getSnippet();
    $attachment = $this->getEmailAttachments($message, $gmail);
    $body = $this->getEmailBody($message);

    foreach ($headers as $single) {
      if ($single->getName() == 'Subject') {
        $message_subject = $single->getValue();
      } elseif ($single->getName() == 'Date') {
        $message_date = $single->getValue();
        $message_date = date('M jS Y h:i A', strtotime($message_date));
      } elseif ($single->getName() == 'From') {
        $message_sender = $single->getValue();
        $message_sender = str_replace('"', '', $message_sender);
      }
    }

    return [
      'mail_id' => $message_id,
      'mail_snippet' => strip_tags($snippet),
      'mail_subject' => $message_subject,
      'mail_date' => $message_date,
      'mail_sender' => $message_sender,
      'attachment' => $attachment,
      'body' => $body
    ];
  }

  private function getEmailBody($message)
  {
    $body = $message->getPayload()->getBody();

    if ($body->getData()) {
      $bodyData = $body->getData();
    } else {
      $parts = $message->getPayload()->getParts();
      $bodyData = $parts[0]['body']->getData();
      $bodyData = strip_tags($bodyData, '<style>');
    }

    return base64_decode(strtr($bodyData, '-_', '+/'));
  }


  private function getEmailAttachments($message, $gmail)
  {
    $parts = $message->getPayload()->getParts();
    $attachments = [];

    foreach ($parts as $part) {
      if ($part['filename'] && $part['body'] && $part['body']->getAttachmentId()) {
        $attachment = $gmail->users_messages_attachments->get('me', $message->getId(), $part['body']->getAttachmentId());

        $attachmentData = [
          'filename' => $part['filename'],
          'data' => strtr($attachment->getData(), '-_', '+/'),
          'content_type' => $part->mimeType,
        ];

        $attachments[] = $attachmentData;
      }
    }

    return $attachments;
  }


  public function replyToEmailById($gmail, $emailId, $subject, $body)
  {
    $message = new Google_Service_Gmail_Message();

    $replyEmail = $gmail->users_messages->get('me', $emailId);
    $threadId = $replyEmail->getThreadId();




    $headers = $replyEmail->getPayload()->getHeaders();
    $replyToAddress = null;

    foreach ($headers as $header) {
      if ($header->getName() === 'Return-Path') {
        $replyToAddress = $header->getValue();
        $replyToAddress = trim($replyToAddress, '<>');
        break;
      }
    }


    $replyMessage = new Google_Service_Gmail_Message();
    $replyMessage->setThreadId($threadId);

    $rawMessage = $this->createReplyRawMessage($replyToAddress, $subject, $body);

    $replyMessage->setRaw($rawMessage);

    $sentMessage = $gmail->users_messages->send('me', $replyMessage);

    return $sentMessage;
  }

  private function createReplyRawMessage($replyToAddress, $subject, $body)
  {
    $rawMessageString = "From: shivtiwari627@gmail.com\r\n";
    $rawMessageString .= "To: $replyToAddress\r\n";
    $rawMessageString .= "Subject: $subject\r\n";
    $rawMessageString .= "In-Reply-To: <REPLY_EMAIL_ID>\r\n";
    $rawMessageString .= "References: <REPLY_EMAIL_ID>\r\n";
    $rawMessageString .= "Content-Type: text/plain; charset=utf-8\r\n";
    $rawMessageString .= "\r\n";
    $rawMessageString .= $body;

    return rtrim(strtr(base64_encode($rawMessageString), '+/', '-_'), '=');
  }
}
