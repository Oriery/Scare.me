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

    public function checkIfLoginExists(string $login) : bool {
        return $this->dbRepo->checkIfLoginExists($login);
    }

    public function signupUser($login, $email, $passwordHash) {
        $this->dbRepo->signupUser($login, $email, $passwordHash);
    }

    public function createMercenary(string $name, int $price, string $desc, string $features) {
        $this->dbRepo->save($name, $price, $desc, explode(',', $features, PHP_INT_MAX));
    }

    public function deleteMercenary(string $name) {
        $this->dbRepo->deleteByName($name);
    }

    public function createHelpElem(string $question, string $answer) {
        $this->dbRepo->saveHelp($question, $answer);
    }

    public function deleteQuestion(string $question) {
        $this->dbRepo->deleteQuestion($question);
    }
}