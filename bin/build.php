#!/usr/bin/env php
<?php

$target = getcwd().'/build';

if (! is_dir($target)) {
    mkdir($target, 0775, true);
}

$source = $argv[1];

foreach (glob($source.DIRECTORY_SEPARATOR.'*.php') as $file) {
    global $slots;

    ob_start();

    include $file;

    $outputPath = str_replace([$source, '.php'], [$target], $file) . '.html';

    file_put_contents(
        $outputPath,
        ob_get_clean()
    );

    $slots = [];
}

function partial($template, $data = []) {
    global $source;

    $path = $source . DIRECTORY_SEPARATOR . $template . '.php';

    if (! file_exists($path)) {
        return;
    }

    extract($data);

    ob_start();

    include $path;

    $output = ob_get_clean();

    return $output;
}

$slots = [];

function extend($template) {
    global $source;

    ob_end_clean();
    ob_start();

    include $source.DIRECTORY_SEPARATOR.$template.'.php';
}

function start() {
    ob_start();
}

function stop($name) {
    global $slots;

    $slots[$name] = ob_get_clean();
}

function slot($name) {
    global $slots;

    return isset($slots[$name]) ? $slots[$name] : null;
}