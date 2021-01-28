<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/IconDAO.php';

class IconsController extends Controller
{
    private $iconDAO;

    function __construct()
    {
        $this->iconDAO = new IconDAO();
    }

    public function readByID($id)
    {
        return $this->iconDAO->readById($id);
    }

    public function handleIcon($data, $action)
    {
        $icon = array();
        $icon['Id'] = $data['IconId'];
        $icon['Icon'] = !empty($data['FontIcon']) ? $data['FontIcon'] : null;
        $icon['IsCustom'] = !empty($data['FontIcon']) ? 0 : 1;

        $id = null;
        switch ($action) {
            case 'create':
                $nextId = $this->iconDAO->getNextId();
                if ($icon['IsCustom']) {
                    $icon['Icon'] = $this->_handleUpload($data['CustomIcon'], $nextId['ID']);
                }
                $id = $this->iconDAO->create($icon);
                break;
            case 'update':
                if ($data['UpdateIcon']) {
                    if ($icon['IsCustom']) {
                        $icon['Icon'] = $this->_handleUpload($data['CustomIcon'], $icon['Id']);
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
        if (DIRECTORY_SEPARATOR == '/'){
            $folder = dirname(__DIR__) . '/images/Icons/';
        }
        else
        {
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
        return null;
    }
}
