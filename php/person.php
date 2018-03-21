<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json; charset=UTF-8');

	$connect = new mysqli('localhost', 'thinh', 'Ngoc-2403', 'person');

	$result = $connect->query('SELECT * FROM info');

	$output = '';
	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		if ($output != '') {
			$output .= ', ';
		}
		$output .= '{"id": "' . $rs["id"] . '", "firstname": "' . $rs["firstname"] . '", "lastname":"' . $rs["lastname"] . '", "username":"' . $rs["username"] . '", "password":"' . $rs["password"] . '"}';
	}
	$connect->close();

	echo('['.$output.']');
?>