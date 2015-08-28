<?php

class Collection {
	private $collectiondata;
	public function __construct(){
		
	}

	public function parseFromCSVData($csv){
		// this will fail for quoted multiline values in CSV, update to http://csv.thephpleague.com/ sometime?
		$lines = explode(PHP_EOL, $csv);
		$headerdata = str_getcsv(array_shift($lines));
print_r($headerdata);
		$this->collectiondata = array();
		foreach($lines as $line){
			$row = array();
			$rowvalues = str_getcsv($line);
			for($i=0;$i<count($headerdata);$i++){
				$row[$headerdata[$i]] = $rowvalues[$i];
			}
			$this->collectiondata[] = $row;
		}
		
	}

	public function getEntries(){
print_r($this->collectiondata);
		return $this->collectiondata;
	}


}

?>
