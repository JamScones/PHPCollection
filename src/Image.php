<?php
class Image {
	private $source;
	public function __construct(){

	}

	public function setSourcePath($path){
		$this->source = $path;
	}

	public function getMetadata(){
		return array("path"=>$this->source);
	}
}

?>
