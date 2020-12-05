<?php

class DataBase
{
    private $_con;
    private $_config = array(
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'dbname' => 'bddprojet',
        'username' => 'root',
        'password' => ''
    );
    // test
    public function __construct()
    {
        $this->connect();
    }

    public function closeCon()
    {
        $this->_con = null;
    }

    public function connect()
    {
        if ($this->_con == null) {
            $dsn = "" . $this->_config['driver'] . ":host=" . $this->_config['host'] . ";dbname=" . $this->_config['dbname'];
            try {
                $this->_con = new PDO($dsn, $this->_config['username'], $this->_config['password']);
                $this->_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die("Erreur connexion bdd : " . $e->getMessage());
            }
        }
    }

    public function getCon()
    {
        return $this->_con;
    }
}

$bdd = new DataBase();
$con = $bdd->getCon();

/*$requete = "SELECT * FROM role";
$reponse = $con->query($requete);
$donne = $reponse->fetch();
$nomRole = $donne['nom_role'];
echo "<p> nome role est $nomRole</p>";
*/






