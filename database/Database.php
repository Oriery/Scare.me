<?php

class Database
{
    private $link;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $config = require_once(__DIR__ . '/../configuration/databaseConfig.php');
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];

        $this->link = new PDO($dsn, $config['username'], $config['password']);

        return $this;
    }

    public function getMercenaries(): array {
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

    public function getHelpElements(): array {
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

    public function getFeaturesByMercId(int $id): array {
        $sql = "SELECT feature FROM mercenaries
                INNER JOIN mercenaries_features ON mercenaries.id = mercenaries_features.mercenary_id
                INNER JOIN features ON mercenaries_features.feature_id = features.id
                WHERE mercenary_id = ?;";

        $sth = $this->link->prepare($sql);

        $sth->execute([$id]);

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result === false) {
            return [];
        } else {
            return $result;
        }
    }

    public function checkIfValidAuth(string $login, string $passHash) : bool {
        $sql = "SELECT login FROM users WHERE login = ? AND passHash = ?;";

        $sth = $this->link->prepare($sql);
        $sth->execute([$login, $passHash]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return isset($result[0]);
    }

    public function checkIfAdmin(string $login) : bool {
        $sql = "SELECT id FROM admins 
        INNER JOIN users on users.id = admins.user_id
        WHERE login = ?;";

        $sth = $this->link->prepare($sql);
        $sth->execute([$login]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return isset($result[0]);
    }

    public function checkIfLoginExists(string $login) : bool {
        $sql = "SELECT login FROM `users` WHERE login = ?;";

        $sth = $this->link->prepare($sql);
        $sth->execute([$login]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return isset($result[0]);
    }

    public function signupUser($login, $passwordHash) {
        $sql = "INSERT INTO users (login, passHash) VALUES (?, ?);";

        $sth = $this->link->prepare($sql);
        $sth->execute([$login, $passwordHash]);
    }

    public function checkEmailValidationKey(string $login, string $email, string $key) : bool {
        return $this->getKeyForEmailValidation($login, $email) == $key;
    }

    function getEmailValidationKey(string $login, string $email, string $passHash, string $hash) : string{
        return md5($login . $email . $passHash . $hash);
    }

    public function getKeyForEmailValidation(string $login, string $email) : string {
        $sql = "SELECT passHash, hash FROM users WHERE login = ?";
        
        $sth = $this->link->prepare($sql);
        $sth->execute([$login]);
        $result = $sth->fetch();
        $passHash = $result["passHash"];
        $hash = $result["hash"];

        if ($hash == null) {
            $hash = $this->generateRandomHash();

            $sql = "UPDATE users SET hash=? WHERE login = ?;";
            $sth = $this->link->prepare($sql);
            $sth->execute([$hash, $login]);
        }

        return $this->getEmailValidationKey($login, $email, $passHash, $hash);
    }

    public function setUserEmail(string $login, string $email) {
        $sql = "UPDATE users SET email=? WHERE login = ?;";

        $sth = $this->link->prepare($sql);
        $sth->execute([$email, $login]);
    }

    private function generateRandomHash() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 32; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function save(string $name, int $price, string $desc, $features) {
        $sql = "INSERT INTO mercenaries (name, price, description) VALUES (?, ?, ?);";
        $sth = $this->link->prepare($sql);
        $sth->execute([$name, $price, $desc]);
        $merc_id = $this->link->lastInsertId();

        foreach($features as $f) {
            $sql = "SELECT id, feature FROM features f WHERE f.feature = ?";
            $sth = $this->link->prepare($sql);
            $sth->execute([trim($f)]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            print_r($result);
            if (empty($result)) {
                $sql = "INSERT INTO features (feature) VALUE (?);";
                $sth = $this->link->prepare($sql);
                $sth->execute([trim($f)]);
                $feature_id = $this->link->lastInsertId();
            } else {
                $feature_id = $result[0]['id'];
            }
            $sql = "INSERT INTO mercenaries_features (mercenary_id, feature_id) VALUES (?, ?);";
            $sth = $this->link->prepare($sql);
            $sth->execute([$merc_id, $feature_id]);
        }
    }

    public function deleteByName(string $name) {
        $sql = "DELETE mf FROM mercenaries_features mf 
                INNER JOIN mercenaries m ON mf.mercenary_id = m.id
                WHERE m.name = ?;
                DELETE m FROM mercenaries m WHERE m.name = ?;";

        $sth = $this->link->prepare($sql);
        $sth->execute([$name, $name]);
    }

    public function saveHelp($question, $answer) {
        $sql = "INSERT INTO help (question, answer) VALUES (?, ?)";
        $sth = $this->link->prepare($sql);
        $sth->execute([$question, $answer]);
    }

    public function deleteQuestion(string $question) {
        $sql = "DELETE FROM help WHERE help.question = ?";
        $sth = $this->link->prepare($sql);
        $sth->execute([$question]);
    }

    public function getEmails() {
        $sql = "SELECT email FROM users";
        $sth = $this->link->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
