<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/IconDAO.php';
require_once __DIR__ . '/../dao/IconSetDAO.php';

class IconsController extends Controller
{
    private $iconDAO;
    private $iconSetDAO;

    function __construct()
    {
        $this->iconDAO = new IconDAO();
        $this->iconSetDAO = new IconSetDAO();
    }

    public function readByID($id)
    {
        return $this->iconDAO->readById($id);
    }

    public function handleIcon($data, $action)
    {
        $icon = array();
        $icon['Id'] = $data['IconId'];
        $icon['IsCustom'] = empty($data['IconSetId']) ? 1 : 0;
        $icon['Icon'] = !empty($data['IconFile']) ? $data['IconFile'] : null;

        $id = null;
        switch ($action) {
            case 'create':
                if ($icon['IsCustom']) {
                    $nextId = $this->iconDAO->getNextId();
                    $icon['Icon'] = $this->_handleUpload($data['IconFile'], $nextId['ID']);
                } else {
                    $iconSet = $this->iconSetDAO->readByID($data['IconSetId']);
                    $icon['Icon'] = $iconSet['Icon'];
                }
                $id = $this->iconDAO->create($icon);
                break;
            case 'update':
                if ($data['UpdateIcon']) {
                    if ($icon['IsCustom']) {
                        $icon['Icon'] = $this->_handleUpload($data['IconFile'], $icon['Id']);
                    } else {
                        $iconSet = $this->iconSetDAO->readByID($data['IconSetId']);
                        $icon['Icon'] = $iconSet['Icon']; 
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
                $folder = dirname(__DIR__) . '/images/Icons/';
            } else {
                $folder = str_replace('\\', '/', dirname(__DIR__)) . '/images/Icons/';
            }

            $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
            $fileLoc = $folder . $id . '.' . $ext;
            $file = 'images/Icons/' . $id . '.' . $ext;

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
