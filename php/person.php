<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json; charset=utf8');

	class database {
		public $hostname = 'localhost', $username = 'root', $password = '', $database = 'person', $connect = null;
		public function __construct() {
			$this->connect = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
			if ($this->connect->connect_error) {
				die('Connection failed: ' . $this->connect->connect_error);
			}
			//mysql_query("set names 'utf8'");
			//mysqli_set_charset($connect, 'utf8');
		}
		function disconnect() {
			return $connect = $this->connect;
		}
	}

	class user extends database {
		function show_user() {
			$result = mysqli_query($this->connect, "SELECT * FROM info");
			return $result;
		}
		function register_user($firstname, $lastname, $username, $password) {
			if(isset($_POST) && isset($_POST['action'])) {
				if($_POST['action'] == 'register') {
					$firstname = $_POST['firstname'];
					$lastname = $_POST['lastname'];
					$username = $_POST['username'];
					$password = $_POST['password'];
					$sql = "INSERT INTO info (firstname, lastname, username, password) VALUES('" . $firstname . "', '" . $lastname . "', '" . $username . "', MD5('" . $password . "'))";
					mysqli_query($this->connect, $sql);
					$result = mysqli_query($this->connect, "SELECT * FROM info");
					return $result;
				}
			}
		}
		function edit_user($id, $firstname, $lastname, $username, $password) {
			$id = $_POST['id'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			if(isset($_POST) && isset($_POST['action'])) {
				if ($_POST['action'] == 'edit' && isset($_POST['id'])) {
					$sql = "UPDATE info SET firstname='" . $firstname . "', lastname='" . $lastname . "', username='" . $username . "', password=MD5('" . $password . "') WHERE id=" . $id;
					mysqli_query($this->connect, $sql);
					$result = mysqli_query($this->connect, "SELECT * FROM info");
					return $result;
				}
			}
		}
		function delete_user($id) {
			$id = $_POST['id'];
			if(isset($_POST) && isset($_POST['action'])) {
				if ($_POST['action'] == 'delete' && isset($_POST['id'])) {
					$sql = "DELETE FROM info WHERE id=" . $id;
					mysqli_query($this->connect, $sql);
					$result = mysqli_query($this->connect, "SELECT * FROM info");
					return $result;
				}
			}
		}
	}

	$user = new user;
	$output = '';
	
	if(isset($_POST) && isset($_POST['action'])) {
		if($_POST['action'] == 'register') {
			$result_register = $user->register_user($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password']);
			while ($row_register = mysqli_fetch_array($result_register, MYSQLI_ASSOC)) {
				if ($output != '') {
					$output .= ', ';
				}
				$output .= '{"id": "' . $row_register["id"] . '", "firstname": "' . $row_register["firstname"] . '", "lastname": "' . $row_register["lastname"] . '", "username": "' . $row_register["username"] . '", "password": "' . $row_register["password"] . '"}';
			}
			mysqli_free_result($result_register);
			echo ('[' . $output . ']');
		}
		elseif ($_POST['action'] == 'edit' && isset($_POST['id'])) {
			$result_edit = $user->edit_user($_POST['id'], $_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password']);
			while ($row_edit = mysqli_fetch_array($result_edit, MYSQLI_ASSOC)) {
				if ($output != '') {
					$output .= ', ';
				}
				$output .= '{"id": "' . $row_edit["id"] . '", "firstname": "' . $row_edit["firstname"] . '", "lastname": "' . $row_edit["lastname"] . '", "username": "' . $row_edit["username"] . '", "password": "' . $row_edit["password"] . '"}';
			}
			mysqli_free_result($result_edit);
			echo ('[' . $output . ']');
		}
		elseif ($_POST['action'] == 'delete' && isset($_POST['id'])) {
			$result_delete = $user->delete_user($_POST['id']);
			while ($row_delete = mysqli_fetch_array($result_delete, MYSQLI_ASSOC)) {
				if ($output != '') {
					$output .= ', ';
				}
				$output .= '{"id": "' . $row_delete["id"] . '", "firstname": "' . $row_delete["firstname"] . '", "lastname": "' . $row_delete["lastname"] . '", "username": "' . $row_delete["username"] . '", "password": "' . $row_delete["password"] . '"}';
			}
			mysqli_free_result($result_delete);
			echo ('[' . $output . ']');
		}
	}
	else {
		$result_show = $user->show_user();
		while ($row_show = mysqli_fetch_array($result_show, MYSQLI_ASSOC)) {
			if ($output != '') {
				$output .= ', ';
			}
			$output .= '{"id": "' . $row_show["id"] . '", "firstname": "' . $row_show["firstname"] . '", "lastname": "' . $row_show["lastname"] . '", "username": "' . $row_show["username"] . '", "password": "' . $row_show["password"] . '"}';
		}
		mysqli_free_result($result_show);
		echo ('[' . $output . ']');
	}

	$connect = new database;
	$disconnect = $connect->disconnect();
	mysqli_close($disconnect);
?>