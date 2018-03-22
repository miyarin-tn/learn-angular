<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	$connect = new mysqli('localhost', 'root', '', 'person');
	if ($connect->connect_error) {
		die('Connection failed: ' . $connect->connect_error);
	}

	if(isset($_POST) && isset($_POST['action'])) {
		if($_POST['action'] == 'register') {
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$sql = $connect->query("INSERT INTO info (firstname, lastname, username, password) VALUES('" . $firstname . "', '" . $lastname . "', '" . $username . "', MD5('" . $password . "'))");
			$sql_info = $connect->query("SELECT * FROM info");
			$output = '';
			while($result_info = $sql_info->fetch_array(MYSQLI_ASSOC)) {
				if ($output != '') {
					$output .= ', ';
				}
				$output .= '{"id": "' . $result_info["id"] . '", "firstname": "' . $result_info["firstname"] . '", "lastname":"' . $result_info["lastname"] . '", "username":"' . $result_info["username"] . '", "password":"' . $result_info["password"].'aaa' . '"}';
			}
			$connect->close();

			echo('['.$output.']');
		}
		elseif ($_POST['action'] == 'edit' && isset($_POST['id'])) {
			$id = $_POST['id'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$sql = $connect->query("UPDATE info SET firstname='" . $firstname . "', lastname='" . $lastname . "', username='" . $username . "', password=MD5('" . $password . "') WHERE id=" . $id);
			$sql_info = $connect->query("SELECT * FROM info");
			$output = '';
			while($result_info = $sql_info->fetch_array(MYSQLI_ASSOC)) {
				if ($output != '') {
					$output .= ', ';
				}
				$output .= '{"id": "' . $result_info["id"] . '", "firstname": "' . $result_info["firstname"].$action . '", "lastname":"' . $result_info["lastname"] . '", "username":"' . $result_info["username"] . '", "password":"' . $result_info["password"] . '"}';
			}
			$connect->close();

			echo('['.$output.']');
		}
		elseif($_POST['action'] == 'delete' && isset($_POST['id'])) {
			$id = $_POST['id'];
			$sql = $connect->query("DELETE FROM info WHERE id=" . $id);
			$sql_info = $connect->query("SELECT * FROM info");
			$output = '';
			while($result_info = $sql_info->fetch_array(MYSQLI_ASSOC)) {
				if ($output != '') {
					$output .= ', ';
				}
				$output .= '{"id": "' . $result_info["id"] . '", "firstname": "' . $result_info["firstname"] . '", "lastname":"' . $result_info["lastname"] . '", "username":"' . $result_info["username"] . '", "password":"' . $result_info["password"] . '"}';
			}
			$connect->close();

			echo('['.$output.']');
		}
	}
	else {
		$sql_info = $connect->query("SELECT * FROM info");
		$output = '';
		while($result_info = $sql_info->fetch_array(MYSQLI_ASSOC)) {
			if ($output != '') {
				$output .= ', ';
			}
			$output .= '{"id": "' . $result_info["id"] . '", "firstname": "' . $result_info["firstname"] . '", "lastname":"' . $result_info["lastname"] . '", "username":"' . $result_info["username"] . '", "password":"' . $result_info["password"] . '"}';
		}
		$connect->close();

		echo('['.$output.']');
	}
?>