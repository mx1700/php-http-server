<?php

$socket = stream_socket_server("tcp://0.0.0.0:8888");
echo "server started\n\n";

while (true) {
    $conn = stream_socket_accept($socket, -1);
    $request = fread($conn, 40960);

    list($header, $body) = explode("\r\n\r\n", $request);
    $header = explode("\r\n", $header);
    list($method, $path_info, $version) = explode(" ", $header[0]);
    if ($path_info == '/') $path_info = '/index.html';

    $file_path = __DIR__ . '/public' . $path_info;

    if (is_file($file_path)) {
        $content = buildContent(file_get_contents($file_path));
    } else {
        $content = buildContent('Not found', 404, 'Not found');
    }

    fwrite($conn, $content);
    fclose($conn);
}

function buildContent($body, $status = 200, $message = 'OK') {
    $length = strlen($body);
    return <<<EOF
HTTP/1.0 $status $message
Server: nginx/99.99
Content-Length: $length

$body
EOF;

}


//Set-Cookie: test=abc
