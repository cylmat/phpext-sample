<?php

/*
Docker

RUN apt-get install -y libzmq3-dev amqp-tools libevent-dev php-amqplib
RUN apt-get install -y librabbitmq-dev librabbitmq4 rabbitmq-server 
RUN apt-get install -y php7.4-amqp php7.4-zmq
RUN echo 'yes' | pecl install swoole event
# composer require amphp/amp react/event-loop react/http
 */

/* ************* 
ZMQ
*/
/*$context = new ZMQContext();
$socket = $context->getSocket(ZMQ::SOCKET_REQ, 'mysock');
$socket->connect("tcp://0.0.0.0:1234");
$socket->send("Hello there");
$message = $socket->recv();*/

/* ***********
SWOOLE
*/
/*$server = new Swoole\HTTP\Server("127.0.0.1", 9501);
$server->on("start", function (Swoole\Http\Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});
$server->on("request", function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("Hello World\n");
});
$server->start();*/

/*
$server = new Swoole\Http\Server("0.0.0.0", 9501, SWOOLE_BASE);
$server->set([
    'worker_num' => 1,
    'task_worker_num' => 2,
]);

$server->on('Request', function ($request, $response) use ($server) {
    $tasks[0] = ['time' => 0];
    $tasks[1] = ['data' => 'www.swoole.co.uk', 'code' => 200];
    $result = $server->taskCo($tasks, 1.5);
    $response->end('<pre>Task Result: '.var_export($result, true));
});
$server->on('Task', function (Swoole\Server $server, $task_id, $worker_id, $data) {
    if ($server->worker_id == 1) {
        sleep(1);
    }
    $data['done'] = time();
    $data['worker_id'] = $server->worker_id;
    return $data;
});
$server->start();
*/

/* ***************
EVENT
*/
/*
$base = new EventBase();
$dns_base = new EventDnsBase($base, TRUE); // Nous utilisons une résolution DNS asynchrone
if (!$dns_base) {
    exit("Echec dans l'initialisation de la base DNS\n");
}
*/