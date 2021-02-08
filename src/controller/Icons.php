<?php

require_once __DIR__ . '/../dao/IconDAO.php';

class Icons
{
    private $iconDAO;

    function __construct()
    {
        $this->iconDAO = new IconDAO();
    }

    public function handleIcon($data, $action)
    {
        $icon = array();
        $icon['Id'] = $data['IconId'];
        $icon['IsCustom'] = empty($data['DefaultIcon']) ? 1 : 0;
        $icon['Icon'] = !empty($data['IconFile']) ? $data['IconFile'] : null;

        $id = null;
        switch ($action) {
            case 'create':
                if ($icon['IsCustom']) {
                    $nextId = $this->iconDAO->getNextId();
                    $icon['Icon'] = $this->_handleUpload($data['IconFile'], $nextId['ID']);
                } else {
                    $icon['Icon'] = $data['DefaultIcon'];
                }
                $id = $this->iconDAO->create($icon);
                break;
            case 'update':
                if ($data['UpdateIcon']) {
                    if ($icon['IsCustom']) {
                        $icon['Icon'] = $this->_handleUpload($data['IconFile'], $icon['Id']);
                    } else {
                        $icon['Icon'] = $data['DefaultIcon'];
                    }
                    $this->iconDAO->update($icon);
                }
                break;
            case 'delete':
                $this->iconDAO->delete($icon['Id']);
                break;
        }
        return $id;
    }

    private function _handleUpload($fileInfo, $id)
    {
        if (!empty($fileInfo)) {
            if (DIRECTORY_SEPARATOR == '/') {
                $folder = dirname(__DIR__) . '/assets/img/icons/';
            } else {
                $folder = str_replace('\\', '/', dirname(__DIR__)) . '/assets/img/icons/';
            }

            $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
            $fileLoc = $folder . $id . '.' . $ext;
            $file = '../../assets/img/icons/' . $id . '.' . $ext;

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            if (move_uploaded_file($fileInfo['tmp_name'], $fileLoc)) {
                return $file;
            }
        }
        return null;
    }
}
