<?php
header('Content-Type: application/json');
$base = '/assets/img/articles/';
$path = realpath(dirname(__FILE__)) . $base;

$errors = [
    'There is no error, the file uploaded with success',
    'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    'The uploaded file was only partially uploaded',
    'No file was uploaded',
    'Missing a temporary folder',
    'Failed to write file to disk.',
    'A PHP extension stopped the file upload.',
];

// Black and white list
$config = [
    'white_extensions' => ['png', 'jpeg', 'gif', 'jpg'],
    'black_extensions' => ['php', 'exe', 'phtml'],
];

function makeSafe($file)
{
    $file = rtrim($file, '.');
    $regex = ['#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#'];
    return trim(preg_replace($regex, '', $file));
}

$result = (object)['error' => 0, 'msg' => [], 'images' => []];

function warning_handler($errno, $errstr)
{
    global $result;
    $result->error = $errno;
    $result->msg[] = $errstr;
    exit(json_encode($result));
}

set_error_handler('warning_handler', E_ALL);

if (
    isset($_FILES['files'])
    and is_array($_FILES['files'])
    and isset($_FILES['files']['name'])
    and is_array($_FILES['files']['name'])
    and count($_FILES['files']['name'])
) {
    foreach ($_FILES['files']['name'] as $i => $file) {
        if ($_FILES['files']['error'][$i]) {
            trigger_error(isset($errors[$_FILES['files']['error'][$i]]) ? $errors[$_FILES['files']['error'][$i]] : 'Error', E_USER_WARNING);
            continue;
        }
        $tmp_name = $_FILES['files']['tmp_name'][$i];

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (move_uploaded_file($tmp_name, $file = $path . makeSafe($_FILES['files']['name'][$i]))) {
            $info = pathinfo($file);
            // check whether the file extension is included in the whitelist
            if (isset($config['white_extensions']) and count($config['white_extensions'])) {
                if (!in_array(strtolower($info['extension']), $config['white_extensions'])) {
                    unlink($file);
                    trigger_error('File type not in white list', E_USER_WARNING);
                    continue;
                }
            }
            //check whether the file extension is included in the black list
            if (isset($config['black_extensions']) and count($config['black_extensions'])) {
                if (in_array(strtolower($info['extension']), $config['black_extensions'])) {
                    unlink($file);
                    trigger_error('File type in black list', E_USER_WARNING);
                    continue;
                }
            }
            $result->msg[] = 'File ' . $_FILES['files']['name'][$i] . ' was upload';
            $result->images[] = $base . basename($file);
        } else {
            $result->error = 5;
            if (!is_writable($path)) {
                trigger_error('Destination directory is not writeble', E_USER_WARNING);
            } else {
                trigger_error('No images have been uploaded', E_USER_WARNING);
            }
        }
    }
};

if (!$result->error and !count($result->images)) {
    $result->error = 5;
    trigger_error('No files have been uploaded', E_USER_WARNING);
}

exit(json_encode($result));
