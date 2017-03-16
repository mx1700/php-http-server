<?php

$socket = stream_socket_server("tcp://0.0.0.0:8888", $errno, $errstr);
echo "server start\n\n";

while (true) {
    $conn = stream_socket_accept($socket, -1);
    echo "\n----- CONN -----\n";
    $request = fread($conn, 40960);
    echo $request;
    echo "\n----- EOF  -----\n";

    $html = "<html><h1>hello world</h1></html>";
    $html = '';

    $length = strlen($html);
    fwrite($conn, <<<EOF
HTTP/1.1 401 Unauthorized
Server: nginx/99.99
WWW-Authenticate: Basic realm="blahblah"
Content-Length: $length

$html
EOF
    );
    fclose($conn);
}
