<?php
function console(mixed $data)
{
    ob_start();
    var_dump($data);
    $debug_str = ob_get_clean();
    file_put_contents("php://stdout", $debug_str);
}