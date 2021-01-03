<?php

function pd($data)
{
    echo '<style>
        *{
            margin: 0;
            padding: 0;
        }
    </style>
    <pre style="background:black; color:green; padding: 30px ; white-space: pre-wrap; font-size: 16px ; margin:20px;">';
    print_r($data);
    echo '</pre>';
    die();
}
function dd($data)
{
    echo '<style>
        *{
            margin: 0;
            padding: 0;
        }
    </style>
    <pre style="background:black; color:green; padding: 30px ; white-space: pre-wrap; font-size: 16px; margin:20px;">';
    var_dump($data);
    echo '</pre>';
    die();
}
function imageRender($img_ref){
    if (preg_match("/^http?/", $img_ref)) {
        return ($img_ref);
    } else {
        return ("http://" . HOST .$img_ref);
    }
}


function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function alert($output, $with_script_tags = true)
{
    $js_code = 'window.alert(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function confirm($output, $with_script_tags = true)
{
    $js_code = 'window.confirm(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
