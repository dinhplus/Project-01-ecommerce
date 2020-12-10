<?php
function console_log($output, $with_script_tags = true){
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
    ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function alert($output, $with_script_tags = true){
    $js_code = 'window.alert(' . json_encode($output, JSON_HEX_TAG) .
    ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function confirm($output, $with_script_tags = true){
    $js_code = 'window.confirm(' . json_encode($output, JSON_HEX_TAG) .
    ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}