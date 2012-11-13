<?php

$f = htmlspecialchars($_GET['f']);

$rFile = @fopen($f, 'r');
$rOutput = fopen('php://output', 'w');
if($rFile)
{
    header('Content-Disposition: attachment; filename='.'attachment.jpg');
    stream_copy_to_stream($rFile, $rOutput);
    exit();
}
?>
