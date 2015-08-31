<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h1>List view</h1>
<?php
	require dirname(__FILE__)."/autoload.php";
	$collection = new Collection();
	$collection->parseFromCSVData(file_get_contents(dirname(__FILE__)."/../private/collection.csv"));
	foreach($collection->getEntries() as $entry){
?>
		<div>
			<div>
				<p><strong><?php print($entry["Type"].":".$entry["Description"]);?></strong></p>
				<p><?php print($entry["Description"]); ?></p>	
			</div>
			<div>
				<img src="imageview.php?file=<?php print($entry["Files"][0]->getMetadata()["path"]);?>&width=128" />
			</div>
		</div>
<?php
	}
?>
	</body>
</html>
