<?php
	// Loon andmebaasi ühenduse
	require_once("../../config_global.php");
	$database = "if15_henrrom";
	
	function getCarData($keyword=""){
		$search = "%%";
		
		if($keyword == ""){
			//ei oti midagi
			echo "Ei otsi ";
		}else{
			//otsin
			echo"Otsin ".$keyword;
			$search = "%".$keyword."%";
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color from car_plates WHERE deleted IS NULL AND (number_plate LIKE ? OR color LIKE ?)");
		$stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($id, $user_id_from_database, $number_plate, $color);
		$stmt->execute();
		
		//tekitan tühja massiivi, kus edaspidi hoian objekte 
		$car_array = array();
		
		//tee midagi seni, kuni saad ab'st ühe rea andmeid.
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu.
			
			//tekitan objekti; kus hakkan hoidma väärtusi
			$car = new StdClass();
			$car->id = $id;
			$car->user_id = $user_id_from_database;
			$car->plate = $number_plate;
			$car->color = $color;
			
			//lisan massiivi
			array_push($car_array, $car);
			//var_dump ütleb muutuja tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus kõik read sees
		return $car_array;
			
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteCar($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			//sai kustutatud
			//kustutame aadresirea tühjaks
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function updateCar($id, $number_plate, $color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		if($stmt->execute()){
			//sai uuendatud
			//kustutame aadresirea tühjaks
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}	
?>