<?php

//request template for email sending
$pack = [
    "user" => [
	"id" => "ID",
	"name" => "username",
	"credential" => "email@example.com",
    ],
    "channel" => "email",
    "notification" => [
	"subject" => "Тема письма",
	"body" => "Текст письма"
    ]
];
//test request emulation
$i = 0;
while ($i <= 15000) {
    $i++;
    $pack['user']['id'] = $i;
    $pack['user']['name'] = 'UserName-' . $i;
    $pack['user']['credential'] = 'user' . $i . '-email@example.com';
    echo $pack['user']['name'].', '.$pack['user']['credential'].'<br>'; //user log
    // connect to Gearman server
    $client = new GearmanClient();
    $client->addServer('127.0.0.1', '4730');
    //send a messages to a queue with different channels. For each channel we can create a one or many workers which could work async
    switch ($pack['channel']) {
	case 'email':
	    $client->doBackground('sendmail', json_encode($pack)); 
	    break;
	case 'push':
	    $client->doBackground('sendpush', json_encode($pack)); 
	    break;
	default:
	    break;
    }
}
