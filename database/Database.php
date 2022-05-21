<?php

class Database
{
    private $link;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $config = require_once(__DIR__ . '/../configuration/databaseConfig.php');
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];

        $this->link = new PDO($dsn, $config['username'], $config['password']);

        return $this;
    }

    public function execute($sql)
    {
        $sth = $this->link->prepare($sql);
        return $sth->execute();
    }

    public function getMercenaries(): array
    {
        $sql = "SELECT id, name, price, description FROM mercenaries";
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result === false) {
            return [];
        } else {
            return $result;
        }
    }

    public function getHelpElements(): array
    {
        $sql = "SELECT question, answer FROM help";
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result === false) {
            return [];
        } else {
            return $result;
        }
    }

    public function getFeaturesByMercId(int $id): array
    {
        $sql = "SELECT feature FROM mercenaries
                INNER JOIN mercenaries_features ON mercenaries.id = mercenaries_features.mercenary_id
                INNER JOIN features ON mercenaries_features.feature_id = features.id
                WHERE mercenary_id = $id;";

        $sth = $this->link->prepare($sql);

        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result === false) {
            return [];
        } else {
            return $result;
        }
    }

    public function checkIfValidAuth(string $login, string $passHash): bool
    {
        $sql = "SELECT login FROM users WHERE login = $login AND passHash = $passHash;";

        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return isset($result[0]);
    }

    public function checkIfAdmin(string $login): bool
    {
        $sql = "SELECT id FROM admins 
        INNER JOIN users on users.id = admins.user_id
        WHERE login = $login;";

        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return isset($result[0]);
    }

    public function save(string $name, int $price, string $desc) {
        $sql = "INSERT INTO mercenaries (name, price, description) VALUES (?, ?, ?);";
        $sth = $this->link->prepare($sql);
        $sth->execute([$name, $price, $desc]);
    }

    public function deleteByName(string $name) {
        $sql = "DELETE FROM mercenaries 
                INNER JOIN mercenaries_features ON mercenaries.id = mercenaries_features.mercenary_id 
                WHERE mercenaries.name = $name;";
        $this->execute($sql);
    }

    public function saveHelp($question, $answer) {
        $sql = "INSERT INTO help (question, answer) VALUES (?, ?)";
        $sth = $this->link->prepare($sql);
        $sth->execute([$question, $answer]);
    }
}
