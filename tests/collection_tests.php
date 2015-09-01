<?php

class CollectionTest extends PHPUnit_Framework_TestCase {

	public function testCollectionLoadedDataGetsRightNumberOfRows(){
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
	public function testCollectionKeynameMatchColumnHeaders(){
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
	public function testCollectionFileListColumn(){
		$testdata = <<<EOF
Number,Type,Description,Notes,Files
1,Drawing,A drawing of a fish, fishy fishy fishy, /nonexistent/path.jpg;/another/badpath.jpg
EOF;
		$collection = new Collection();
		$collection->parseFromCSVData($testdata);
		$entries = $collection->getEntries();
		$this->assertEquals(2,count($entries[0]["Files"]));
		$this->assertInstanceOf("Image",$entries[0]["Files"][0]);
	}
	public function testImageSetSourcePath(){
		$image = new Image();
		$image->setSourcePath("/some/file/path");
		$this->assertEquals("/some/file/path",$image->getMetadata()["path"]);
	}
	public function testImageReturnImage(){
		$image = new Image();
		$image->setSourcePath("tests/test.jpg");
		$data = $image->getImage();
		$testdata = file_get_contents("tests/test.jpg");
		$this->assertEquals($testdata,$data);
	}
	public function testImageCacheGeneration(){
		$image = new Image();
		$image->clearCache();
		$image->setSourcePath("tests/test.jpg");
		$foo = $image->getImage(128);
		$metadata = $image->getMetadata();
		$this->assertEquals(true,file_exists(Image::$cache_directory));
		$this->assertEquals(3,count(scandir(Image::$cache_directory)));
	}
	public function testCacheClearSafety(){
		$tmp = Image::$cache_directory;
		Image::$cache_directory="/";
		$image = new Image();
		$bang = false;
		try{
			$image->clearCache();
		}catch(Exception $e){
			$bang=true;
		}
		Image::$cache_directory = $tmp;
		$this->assertEquals(true,$bang);
	}
	public function testImageClearCache(){
		$image = new Image();
		$image->setSourcePath("tests/test.jpg");
		$image->getImage(128);
		$this->assertEquals(true,file_exists(Image::$cache_directory));
		$this->assertEquals(3,count(scandir(Image::$cache_directory)));
		$image->clearCache();
		$this->assertEquals(false,file_exists(Image::$cache_directory));
		$this->assertEquals(false,file_exists(Image::$cache_hints_file));
	}
	public function testImageCacheRetrivalWorks(){
		$this->assertEquals("Have you written this","no");
	}
}

?>
