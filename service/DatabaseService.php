<?php

class DatabaseService
{
    private $dbRepo;

    public function __construct()
    {
        require_once 'database/Database.php';
        $this->dbRepo = new Database();
    }

    public function getAllMercinaries() : array {
        return $this->dbRepo->getMercenaries();
    }

    public function getFeaturesByMercId(int $id) : array {
        return $this->dbRepo->getFeaturesByMercId($id);
    }

    public function getHelp() : array {
        return $this->dbRepo->getHelpElements();
    }
}