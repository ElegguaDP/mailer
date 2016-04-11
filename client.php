<?php

//наполнение очереди
//Шаблон входящего запроса на отправку уведомления.
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

$i = 0;
while ($i <= 15000) {
    $i++;
    $pack['user']['id'] = $i;
    $pack['user']['name'] = 'UserName-' . $i;
    $pack['user']['credential'] = 'user' . $i . '-email@example.com';
    //отправка в очередь записи для разных типов сообщений
    switch ($pack['channel']) {
	case 'email':
		// подключение к серверу очередей. Можно подключить несколько серверов
		$client = new GearmanClient();
		$client->addServer('127.0.0.1', '4730');
	    $client->doBackground('sendmail', json_encode($pack)); 
	    break;
	case 'push':
		// подключение к серверу очередей. Можно подключить несколько серверов
		$client = new GearmanClient();
		$client->addServer('127.0.1.1', '4732');

	    $client->doBackground('sendpush', json_encode($pack)); 
	    break;
	default:
	    break;
    }
}
