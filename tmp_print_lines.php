<?php
$lines = file(__DIR__ . '/resources/views/student/course-show.blade.php');
foreach ($lines as $i => $line) {
    echo ($i+1) . ': ' . rtrim($line, "\r\n") . PHP_EOL;
}
