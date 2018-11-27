<?php

class Import
{
    public function initImportAction($action) {

        switch($action) {
            case "add":
                $this->addFile();
                break;
        }

        $response = $_POST['file'];
        _log($response);
        return $response;
    }

    public function addFile() {
        //$response = $_FILES;
    }
}