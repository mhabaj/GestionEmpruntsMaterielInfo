<?php


class DataBase
{
    private $_con;
    private $_filePath = ("E:\wamp64\www\GestionEmpruntsMaterielInfo\code\assets\ScriptBDD.sql");
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

    /**
     * @function    restoreDatabaseTables
     * @usage       Restore database tables from a SQL file
     */
    function restoreDatabaseTables()
    {
        // Connect & select the database
        $db = new mysqli($this->_config['host'], $this->_config['username'], $this->_config['password'], $this->_config['dbname']);

        // Temporary variable, used to store current query
        $templine = '';

        // Read in entire file
        $lines = file($this->_filePath);

        $error = '';

        // Loop through each line
        foreach ($lines as $line){
            // Skip it if it's a comment
            if(substr($line, 0, 2) == '--' || $line == ''){
                continue;
            }

            // Add this line to the current segment
            $templine .= $line;

            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';'){
                // Perform the query
                if(!$db->query($templine)){
                    $error .= 'Error performing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
                }

                // Reset temp variable to empty
                $templine = '';
            }
        }
        return !empty($error)?$error:true;
    }
}






