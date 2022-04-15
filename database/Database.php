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
        $config = require_once 'configuration/databaseConfig.php';
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
                WHERE mercenary_id = :mercId;";

        $sth = $this->link->prepare($sql);

        $sth->bindParam("mercId", $id, PDO::PARAM_INT);

        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result === false) {
            return [];
        } else {
            return $result;
        }
    }
}
