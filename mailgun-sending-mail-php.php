<?php
function mg_send($to, $subject, $message) {

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_USERPWD, 'api:API-KEY-HERE');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $plain = strip_tags(br2nl($message));

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/DOMAIN-NAME-HERE/messages');
  curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'FROM-MAIL-HERE',
        'to' => $to,
        'subject' => $subject,
        'html' => $message,
        'text' => $plain));

  $j = json_decode(curl_exec($ch));

  $info = curl_getinfo($ch);

  if($info['http_code'] != 200)
        error("Error message here");

  curl_close($ch);

  return $j;
}