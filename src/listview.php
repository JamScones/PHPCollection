<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h1>List view</h1>
<?php
	require dirname(__FILE__)."/autoload.php";
	$collection = new Collection();
	$collection->parseFromCSVData(file_get_contents(dirname(__FILE__)."/".$collection_file_path));
	$entries = $collection->getEntries();
	for($i=0;$i<count($entries);$i++){
		$entry = $entries[$i];
?>
		<div>
			<div>
				<p><strong><?php print($entry["Type"].":".$entry["Description"]);?></strong></p>
				<p><?php print($entry["Description"]); ?></p>	
			</div>
			<div>
				<img src="imageview.php?entry=<?php print($i);?>&image=0&width=128" />
			</div>
		</div>
<?php
	}
?>
	</body>
</html>
