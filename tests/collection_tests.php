<?php

class CollectionTest extends PHPUnit_Framework_TestCase {

	public function testLoadedDataGetsRightNumberOfRows(){
		$testdata = <<<EOF
Number,Type,Description,Notes,Files
1,Drawing,A drawing of a fish, fishy fishy fishy, /nonexistent/path.jpg
2,Drawing,A drawing of a dog, dogy dogy, /nonexistent/path2.jpg
EOF;
		$collection = new Collection();
		$collection->parseFromCSVData($testdata);
		$entries = $collection->getEntries();
		$this->assertEquals(2,count($entries));
	}
	public function testKeynameMatchColumnHeaders(){
		$testdata = <<<EOF
Number,Type,Description,Notes,Files
1,Drawing,A drawing of a fish, fishy fishy fishy, /nonexistent/path.jpg
2,Drawing,A drawing of a dog, dogy dogy, /nonexistent/path2.jpg
EOF;
		$collection = new Collection();
		$collection->parseFromCSVData($testdata);
		$entries = $collection->getEntries();
		$this->assertArrayHasKey("Type",$entries[0]);
	}
	public function testFileListColumn(){
		$testdata = <<<EOF
Number,Type,Description,Notes,Files
1,Drawing,A drawing of a fish, fishy fishy fishy, /nonexistent/path.jpg;/another/badpath.jpg
2,Drawing,A drawing of a dog, dogy dogy, /nonexistent/path2.jpg
EOF;
		$collection = new Collection();
		$collection->parseFromCSVData($testdata);
		$entries = $collection->getEntries();
		$this->assertEquals(2,count($entries[0]["Files"]));
	}

}

?>
