
<?php
 
/**
 * A class file to connect to database
 */
class DB_CONNECT {
 
    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }
 
    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }
 
    /**
     * Function to connect with database
     */
    function connect() {
        // import database connection variables
        require_once '../mantap/db_config.php';
 
        // Connecting to mysql database
        //$con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());
        

        //$con = mysql_connect("mysql.idhostinger.com", "u962869958_mhs", "aditya1478") or die(mysql_error());
        $con = mysqli_connect('localhost', 'zzxqdmac_mantap', 'P@ssword123', 'zzxqdmac_mantap');

        // Selecing database
        //$db = mysql_select_db("u962869958_mhs") or die(mysql_error()) or die(mysql_error());
 
        // returing connection cursor
        return $con;
    }
 
    /**
     * Function to close db connection
     */
    function close() {
        // closing db connection
        mysql_close();
    }
 
}
 
?>