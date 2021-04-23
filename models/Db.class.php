<?php
class Db
{
    private static $instance = null;
    private $_connection;

    private function __construct()
    {
        try {
            $this->_connection = new PDO('mysql:host=localhost;port=3306;dbname=studentvote;charset=utf8','root','');
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        } 
		catch (PDOException $e) {
		    die('Erreur de connexion à la base de données : '.$e->getMessage());
        }
    }

	# Singleton Pattern
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    // ici viennent les fonctions DB...

}
