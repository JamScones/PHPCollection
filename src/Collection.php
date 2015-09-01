<?php

class Collection {
	private $collectiondata;
	public static $image_columns;
	public function __construct(){
		
	}

	public function parseFromCSVData($csv){
		// this will fail for quoted multiline values in CSV, update to http://csv.thephpleague.com/ sometime?
		$lines = explode(PHP_EOL, $csv);
		$headerdata = str_getcsv(array_shift($lines));
		$this->collectiondata = array();
		foreach($lines as $line){
			if($line=="" || $line==null){
				continue;
			}
			$row = array();
			$rowvalues = str_getcsv($line);
			for($i=0;$i<count($headerdata);$i++){
				if(in_array($headerdata[$i],self::$image_columns)){
					$files = explode(";",$rowvalues[$i]);
					foreach($files as $file){
						$image = new Image();
						$image->setSourcePath($file);
						$row[$headerdata[$i]][] = $image;
					}
					
				}else{
					$row[$headerdata[$i]] = $rowvalues[$i];
				}
			}
			$this->collectiondata[] = $row;
		}
		
	}

	public function getEntries(){
		return $this->collectiondata;
	}


}

?>
