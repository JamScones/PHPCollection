<?php

class CollectionTest extends PHPUnit_Framework_TestCase {

	public function TestCollectionList(){
		$testdata = <<<EOF
Number,Type,Description,Notes,Files
1,Drawing,A drawing of a fish, fishy fishy fishy, /nonexistent/path.jpg
2 Drawing,A drawing of a dog, dogy dogy, /nonexistent/path2.jpg
EOF;

		$collection = new Collection();
		$collection->parseFromCSVData($testdata);
		$entries = $collection->getEntries();
		$this->assertEquals(2,count($entries));
	}
}

?>
