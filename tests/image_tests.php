<?php

class CollectionTest extends PHPUnit_Framework_TestCase {
	public function testSetSourcePath(){
		$image = new Image();
		$image->setSourcePath("/some/file/path");
		$this->assertEquals("/some/file/path",$image->getMetadata()["path"]);
	}

}

?>
