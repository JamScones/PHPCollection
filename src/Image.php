<?php
class Image {
	private $source;
	public static $cache_hints_file = null;
	public static $cache_directory = "imagecache";
	public function __construct(){

	}

	public function setSourcePath($path){
		$this->source = $path;
	}

	public function getMetadata(){
		return array(
			"path"=>$this->source,
			"cache"=>[],
		);
	}
	public function getImageRaw(){
		return file_get_contents($this->source);
	}
	public function getImage($newwidth=0){
		if($newwidth > 0){
			return $this->getImageThumbnailWidth($newwidth);
		}else{
			return $this->getImageRaw();
		}
	}
	private function getImageThumbnailWidth($newwidth){
		$cachedimage = $this->getCacheEntry($this->source,$newwidth);
		if($cachedimage==null){
			list($width,$height) = getimagesize($this->source);
			$ratio = $newwidth/$height;
			$newheight = $height*$ratio;
			$image_p = imagecreatetruecolor($newwidth,$newheight);
			$image = imagecreatefromjpeg($this->source);
			imagecopyresampled($image_p,$image,0,0,0,0,$newwidth,$newheight,$width,$height);
			// So apparently, imagejpeg will write to stdout unless you give it a filename.
			// For my purposes I want it in a string so I can both send it to stdout and 
			// save to cache. GD doesn't do a jpegtostring operation, and I don't want to
			// write a file and then have to read it again immediately. So apparently one
			// generates a new output buffer, then saves the content of that before closing
			// the buffer again. )-:
			// apparently imagejpeg returns a boolean, true on success and false on failure,
			// maybe an exception was too hard?
			ob_start();
				imagejpeg($image_p,null, 100);
				$thumbdata = ob_get_contents();
			ob_end_clean();
			$this->cacheImageData($this->source,$thumbdata,$newwidth);
			return $thumbdata;
		}else{
			return $cachedimage
		}
		
	}
	private function getCacheEntry($source,$newwidth){
		if(Image::$cache_hints_file == null){
			return null;
		}
		if(!file_exists(Image::$cache_hints_file)){
			return null;
		}
		$hintsfile = file_get_contents(Image::$cache_hints_file);
		$hintslines = explode(PHP_EOL,$hintsfile);
		foreach($hintslines as $hintline) {
			$hint = str_getcsv($hintline);
			if($hint[0] == $source && $hint[1] == $newwidth){
				return file_get_contents($hint[2]);
			}
		}
		return null;
	}
	private function cacheImageData($filename,$image,$width){
		$cachefilename = Image::$cache_directory."/".uniqid().".jpg";
		if(!file_exists(Image::$cache_directory)){
			mkdir(Image::$cache_directory);
		}
		$file = fopen($cachefilename,"w");
		fwrite($file,$image);
		fclose($file);
		$hintsfile = fopen(Image::$cache_hints_file,"a");
		fwrite($hintsfile,$filename.",".$width.",".$cachefilename."\n");
		fclose($hintsfile);
	}
	public function clearCache(){
		if(Image::$cache_directory == null || Image::$cache_directory == "" || Image::$cache_directory == "/"){
			throw new Exception("Unsafe cache directory");
		}
		if(Image::$cache_hints_file == null || Image::$cache_hints_file == "" || Image::$cache_hints_file =="/"){
			throw new Exception("Unsafe cache directory");
		}
		if(file_exists(Image::$cache_hints_file)){
			unlink(Image::$cache_hints_file);
		}
		if(file_exists(Image::$cache_directory)){
			foreach(glob(Image::$cache_directory."/*")as $file){
				unlink($file);
			}
			rmdir(Image::$cache_directory);
		}
	}
}

?>
