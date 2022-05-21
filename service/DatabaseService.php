<?php

class DatabaseService
{
    private $dbRepo;

    public function __construct()
    {
        require_once __DIR__."/../database/Database.php";
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

    public function checkIfValidAuth(string $login, string $passHash) : bool {
        return $this->dbRepo->checkIfValidAuth($login, $passHash);
    }

    public function checkIfAdmin(string $login) : bool {
        return $this->dbRepo->checkIfAdmin($login);
    }

    public function createMercenary(string $name, int $price, string $desc) {
        $this->dbRepo->save($name, $price, $desc);
    }

    public function deleteMercenary(string $name) {
        $this->dbRepo->deleteByName($name);
    }

    public function createHelpElem($question, $answer) {
        $this->dbRepo->saveHelp($question, $answer);
    }
}