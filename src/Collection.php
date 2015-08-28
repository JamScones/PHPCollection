<?php

class Collection {
	private $collectiondata;
	public function __construct(){
		
	}

	public function parseFromCSVData($csv){
		// this will fail for quoted multiline values in CSV, update to http://csv.thephpleague.com/ sometime?
		$lines = explode(PHP_EOL, $csv);
		//TODO do something with this ... 
		$headerdata = array_shift($lines);
		$this->collectiondata = array();
		foreach($lines as $line){
			$this->collectiondata[] = str_getcsv($line);
		}
		
	}

	public function getEntries(){
		return $this->collectiondata;
	}


}

?>
