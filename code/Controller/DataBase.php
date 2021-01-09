<?php


/**
 * Class DataBase
 * Manages the connections to the database
 *
 * @author Alhabaj Mahmod, Anica Sean, Belda Tom, Ingarao Adrien, Maggouh Naoufal, Ung Alexandre
 */
class DataBase
{
    /**
     * @var
     */
    private $_con;
    /**
     * @var string[]
     */
    private $_config = array(
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'dbname' => 'bddprojet',
        'username' => 'root',
        'password' => ''
    );

    /**
     * DataBase constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Ends the connection with the database
     */
    public function closeCon()
    {
        $this->_con = null;
    }

    /**
     * Starts a connection with the database
     */
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

    /**
     * Purges the database
     */
    public function purgeDatabase()
    {

        $queryEquipments = "DELETE FROM borrow; 
                            DELETE FROM device; DELETE FROM stock_photo ;DELETE FROM borrow_info;DELETE FROM equipment;DELETE FROM users;";
        $myStatement = $this->_con->prepare($queryEquipments);
        $myStatement->execute([]);

        $myStatement->closeCursor();
        $this->_con = null;
    }

    /**
     * @return mixed
     */
    public function getCon()
    {
        return $this->_con;
    }
}






