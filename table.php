<?php

	require_once("functions.php");
	
	//kas kustutame midagi
	//?delete=vastav id mida kustutada, on adressireal
	if(isset($_GET["delete"])){
		
		echo "Kustutame id".$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deleteCar($_GET["delete"]);
		
	}
	
	if(isset($_POST["save"])){
		
		updateCar($_POST["id"],$_POST["plate_number"],$_POST["color"]);
	}
	
	//käivitan funktsiioni
	$array_of_cars = getCarData();
	
	//trükin välja esimese auto
	//echo $array_of_cars[0]->id." ".$array_of_cars[0]->plate;
?>

<h2>Tabel</h2>
<table border="1">
	<tr>
		<th>id</th>
		<th>Kasutaja id</th>
		<th>numbrimärk</th>
		<th>Värvus</th>
		<th>Kustuta</th>
		<th>Muuda</th>
	</tr>
	
	<?php
		//trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_cars); $i++){
			//echo $array_of_cars[$i]->id;
			//echo "<tr>";
			
			if(isset($_GET["edit"]) && $array_of_cars[$i]->id == $_GET["edit"]){
				
				echo"<tr>";
				echo"<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$array_of_cars[$i]->id."'>";
				echo "<td>".$array_of_cars[$i]->id."</td>";
				echo "<td>".$array_of_cars[$i]->user_id."</td>";
				echo "<td><input name='plate_number' value='".$array_of_cars[$i]->plate."'></td>";
				echo "<td><input name='color' value='".$array_of_cars[$i]->color."'></td>";
				echo "<td><a href ='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo"</form>";
				echo"</tr>";
				
			}else{
				echo"<tr>";
				echo "<td>".$array_of_cars[$i]->id."</td>";
				echo "<td>".$array_of_cars[$i]->user_id."</td>";
				echo "<td>".$array_of_cars[$i]->plate."</td>";
				echo "<td>".$array_of_cars[$i]->color."</td>";
				echo "<td> <a href ='?delete=".$array_of_cars[$i]->id."'>X</a></td>";
				echo "<td> <a href ='?edit=".$array_of_cars[$i]->id."'>edit</a></td>";
				echo"</tr>";
			
			}
			
			
			
		}
	
	?>
</table>