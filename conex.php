<?php
	class Conexion {
		
		public static function abrir(){
			try{
				$conn = new PDO('mysql:host=localhost;dbname=mrlomo', 'root', 'mysql',
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';",
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				$conn->exec("SET time_zone='-05:00';");
				return $conn;
			} catch(PDOException $e) {
				echo "Error : " . $e->getMessage();
				die();
			}
		}
	}
?>
