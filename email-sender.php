<?php

$worker = new GearmanWorker();
$worker->addServer();

$worker->addFunction('sendmail', 'send_mail');

while (1) {
    $worker->work();
    if ($worker->returnCode() != GEARMAN_SUCCESS) {
	break;
    }
}

function send_mail($job) {
    $workload = $job->workload();
    $data = json_decode($workload, true);
    //отправка письма, используя любой удобный способ. Например, отправка письма непосредственно сервером, без сервисов рассылки или SMTP
    //mail($data['credential'], $data['notification']['subject'], $data['notification']['body']);
    $fh = fopen('test.html', 'a'); //log
    fwrite($fh, implode(', ', $data['user']).'<br>');
    fclose($fh);
}
