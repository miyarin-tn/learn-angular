<?php
	require_once 'restful_api.php';

	class Api extends RestfulApi {

		public $hostname = 'localhost', $username = 'miyarin_mydata', $password = 'mydata', $database = 'miyarin_mydata', $connect = null;

		function __construct() {
			parent::__construct();
		}

		function connect() {
			$this->connect = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
			if ($this->connect->connect_error) {
				die('Connection failed: ' . $this->connect->connect_error);
			}
			// $connection = mysql_connect('localhost', 'miyarin_mydata', 'mydata');
			// mysql_select_db('miyarin_mydata', $connection);
		}

		function disconnect() {
			return $connect = $this->connect;
		}

		function users() {
			switch ($this->method) {
				case 'GET':
					$this->connect();
					$sql = "SELECT * FROM info";
					$query = mysqli_query($this->connect, $sql);
					$data = array();
					while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
						$data[] = $row;
					}
					mysqli_close($this->connect);
					$this->response(200, $data);
					break;
				case 'POST':
					$this->connect();
					$firstname = $this->params['firstname'];
					$lastname = $this->params['lastname'];
					$username = $this->params['username'];
					$password = $this->params['password'];
					$sql = "INSERT INTO info (firstname, lastname, username, password) VALUES('" . $firstname . "', '" . $lastname . "', '" . $username . "', MD5('" . $password . "'))";
					mysqli_query($this->connect, $sql);
					$query = mysqli_query($this->connect, "SELECT * FROM info");
					$data = array();
					while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
						$data[] = $row;
					}
					mysqli_close($this->connect);
					$this->response(200, $data);
					break;
				case 'PUT':
					$this->connect();
					$respone = (array)json_decode($this->file);
					$id = $this->params[0];
					$firstname = $respone['firstname'];
					$lastname = $respone['lastname'];
					$username = $respone['username'];
					$password = $respone['password'];
					$sql = "UPDATE info SET firstname='" . $firstname . "', lastname='" . $lastname . "', username='" . $username . "', password=MD5('" . $password . "') WHERE id=" . $id;
					mysqli_query($this->connect, $sql);
					$query = mysqli_query($this->connect, "SELECT * FROM info");
					$data = array();
					while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
						$data[] = $row;
					}
					mysqli_close($this->connect);
					$this->response(200, $data);
					break;
				case 'DELETE':
					$this->connect();
					$id = $this->params[0];
					$sql = "DELETE FROM info WHERE id=" . $id;
					mysqli_query($this->connect, $sql);
					$data = array();
					$query = mysqli_query($this->connect, "SELECT * FROM info");
					while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
						$data[] = $row;
					}
					mysqli_close($this->connect);
					$this->response(200, $data);
					break;
				
				default:
					break;
			}
		}
	}
	$api = new Api();
?>
