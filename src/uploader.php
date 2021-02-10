<!-- Adjust 'upload_max_filesize' and 'post_max_size' to handle bigger files -->

<?php
header('Content-Type: application/json');
$base = '/assets/articles/';
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

// Blacklist and tag list
$config = [
    'black_extensions' => ['php', 'exe', 'phtml', 'msi'],
    'image_extensions' => ['png', 'jpeg', 'gif', 'jpg', 'svg'],
    'video_extensions' => ['mp4', 'mov', '3gp'],
    'audio_extensions' => ['mp3', 'mpg', 'mpeg', 'flac', 'wav']
];

function makeSafe($file)
{
    $file = rtrim($file, '.');
    $regex = ['#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#'];
    return trim(preg_replace($regex, '', $file));
}

$result = (object)['error' => 0, 'msg' => [], 'files' => [], 'tags' => []];

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

            //check whether the file extension is included in the black list
            if (isset($config['black_extensions']) and count($config['black_extensions'])) {
                if (in_array(strtolower($info['extension']), $config['black_extensions'])) {
                    unlink($file);
                    trigger_error('File type in black list', E_USER_WARNING);
                    continue;
                }
            }

            // check the file type
            if (isset($config['image_extensions']) and count($config['image_extensions'])) {
                $extension = strtolower($info['extension']);
                $tag;
                if (in_array($extension, $config['image_extensions'])) {
                    $tag = 'img';
                } else if (in_array($extension, $config['video_extensions'])) {
                    $tag = 'video';
                } else if (in_array($extension, $config['audio_extensions'])) {
                    $tag = 'audio';
                } else {
                    $tag = 'a';
                }
                $result->tags[]  = $tag;
            }

            $result->msg[] = 'File ' . $_FILES['files']['name'][$i] . ' was upload';
            $result->files[] = $base . basename($file);
        } else {
            $result->error = 5;
            if (!is_writable($path)) {
                trigger_error('Destination directory is not writeble', E_USER_WARNING);
            } else {
                trigger_error('No files have been uploaded', E_USER_WARNING);
            }
        }
    }
};

if (!$result->error and !count($result->files)) {
    $result->error = 5;
    trigger_error('No files have been uploaded', E_USER_WARNING);
}

exit(json_encode($result));
