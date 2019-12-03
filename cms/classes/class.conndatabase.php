<?php
error_reporting(0);
class DatabaseOld {
	public $dbconn;
	public $dbname;

	function __construct($host,$user,$pass,$db) {
		if ($this->dbconn = mysql_connect($host,$user,$pass) or die(mysql_error())) {
			if ($this->dbname = mysql_select_db($db) or die(mysql_error())) {
				mysql_query("SET NAMES utf8");
				mysql_query("SET CHARACTER_SET utf8");
			} else {
				echo "Erro durante conexão com a base de dados.";
			}
		} else {
			echo "Erro durante conexão com o banco de dados.";
		}
	}

	function __destruct() {
		mysql_close($this->dbconn);
	}
}
class Database {
	public $dbconn;
	public $dbname;
	
	function __construct($host,$user,$pass,$db){
     	if($this->dbconn = mysqli_connect($host, $user, $pass, $db) or die(mysqli_error())){
            mysqli_set_charset($this->dbconn,"utf8");
		} else {
			echo "Erro durante conexão com a base de dados.";
		}
	}

	function query($query){
		return mysqli_query($this->dbconn, $query);
	}
	
	function num_rows($res){
		return mysqli_num_rows($res);
	}
	
	function fetch_array($res){
		return mysqli_fetch_array($res);
	}
	
	function real_escape_string($res){
		return mysqli_real_escape_string($res);
	}
	
	function close(){
        mysqli_close($this->dbconn);
}
}

if(!function_exists('mysql_query')){
	$conn = new Database($config_hostBD, $config_userBD, $config_senhaBD, $config_nomeBD);
} else {
	$conn = new DatabaseOld($config_hostBD, $config_userBD, $config_senhaBD, $config_nomeBD);
}


if(!function_exists('mysql_num_rows')){
	function mysql_num_rows($query){
		global $conn;
		return $conn->num_rows($query);
	}
}

if(!function_exists('mysql_query')){
	function mysql_query($query){
		global $conn;
		return $conn->query($query);
	}
}

if(!function_exists('mysql_fetch_array')){
	function mysql_fetch_array($query){
		global $conn;
		return $conn->fetch_array($query);
	}
}

/**
 * Escapa as mesmas strings do mysql_real_escape_string, mas sem precisar de ponteiro de conexao
 * "Characters encoded are \, ', ", NUL (ASCII 0), \n, \r, and Control+Z"
 * @see https://dev.mysql.com/doc/refman/5.7/en/mysql-real-escape-string.html
 * @see https://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
 * @param string $value
 * @return string
 */
function mres($value)
{
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
    return str_replace($search, $replace, $value);
}
if (!function_exists('mysql_real_escape_string')) {
    /**
     * Escapes special characters in a string for use in an SQL statement
     * @link http://php.net/manual/en/function.mysql-real-escape-string.php
     * The string that is to be escaped.
     * </p>
     * @return string the escaped string, or false on error.
     * @since 4.3.0
     * @since 5.0
     */
    function mysql_real_escape_string($value)
    {
        return mres($value);
    }
}


?>