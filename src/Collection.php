<?php

class Collection {
	private $collectiondata;
	public function __construct(){
		
	}

	public function parseFromCSVData($csv){
		// this will fail for quoted multiline values in CSV, update to http://csv.thephpleague.com/ sometime?
		$lines = explode(PHP_EOL, $csv);
		$collectiondata = array();
		foreach($lines as $line){
			$collectiondata[] = str_getcsv($line);
		}
		
	}


}

?>
