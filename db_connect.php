<?php
//Conexion con el servidor MySQL usando PDO

$host = "192.168.1.20";
$dbname = "openemr";
$username = "openemr";
$password = "openemr";

try {
// Cree un nuevo objeto PDO y guárdelo en la variable $ db
$db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
// Configure el modo de error en PDO para mostrar inmediatamente las excepciones cuando haya errores
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception){
die("Connection error: " . $exception->getMessage());
}
?>
