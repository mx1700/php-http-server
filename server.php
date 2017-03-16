<?php

$socket = stream_socket_server("tcp://0.0.0.0:8888");
echo "server started\n\n";

while (true) {
    $conn = stream_socket_accept($socket, -1);
    echo "@@request\n";
    $request = fread($conn, 40960);
    echo $request;
    echo "\n@@EOF\n";
    fclose($conn);
}
