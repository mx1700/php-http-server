<?php

$socket = stream_socket_server("tcp://0.0.0.0:8888");
echo "server started\n\n";

while (true) {
    $conn = stream_socket_accept($socket, -1);
    $request = fread($conn, 40960);
    echo $request;
    echo "\n@@EOF\n";

    $html = "<html><h1 style='color: green;'>hello world</h1></html>";

    $length = strlen($html);
    fwrite($conn, <<<EOF
HTTP/1.0 200 OK
Server: nginx/99.99
Content-Length: $length

$html
EOF
    );
    fclose($conn);
}


//Set-Cookie: test=abc
