<?php
require dirname(__FILE__)."/autoload.php";

$id = $_GET['entry'];
$image = $_GET['image'];
$width = $_GET['width'];
$collection = new Collection();
$collection->parseFromCSVData(file_get_contents(dirname(__FILE__)."/".$collection_file_path));
header('Content-Type: image/jpeg');
print($collection->getEntries()[$id]["Files"][$image]->getImage($width));


?>
