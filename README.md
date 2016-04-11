# Модуль рассылки уведомлений
Использовался сервер формирования очередей Gearman и расширение PHP gearman. http://gearman.org/download/#php

Логика работы модуля:
1. Запускается сервер gearman. Он постоянно находится в фоновом режиме.
2. Для него создается необходимое колличество workers - скриптов непосредственной отправки уведомлений. Они тоже запускаются в фоновом режиме и постоянно
 запрашивают сервер очередей на наличие новых подходящих записей в очереди. Для примера написан скрипт email_sender.php, которій эмулирует отправку сообщений
 и записывает записи из очереди в файл test.html.
3. Скрипт-клиент client.php, который осуществляет отправку входящих пакетов на сервер очередей.
