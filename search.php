<?php
ini_set('max_execution_time', 3000);

$directories = array('Share1', 'Share2', 'Share3', 'Share4'); // server shares

class search {
	public $important_files = array('.png', '.jpg', '.pdf', '.gif', '.doc'); // files we want to scan for
	public function re2($path) {
		$path = new RecursiveDirectoryIterator($path);
		$bytes = 0;
		$nbfiles = 0;
		foreach(new RecursiveIteratorIterator($path) as $filename=>$cur) {
			$filesize=$cur->getSize(); 
			$filesize2 = $filesize / 1000000 . "MB"; // convert from bytes to MegaBytes
			$bytes+=$filesize;
			$nbfiles++;
			foreach($this->important_files as $filetype) {
				if(strpos($filename, $filetype)) {
					$this->write_to_file("$filename => $filesize2"); // output to file
				}
			}
		}
	}
	public function write_to_file($contents) {
		$fh = fopen('structure.txt', 'a');
		fwrite($fh, $contents . PHP_EOL);
		fclose($fh);
	}
}

$a = new search();
foreach($directories as $dir) {
	$a->re2("\\\\SERVER\\".$dir);
}
echo "\nDONE\n";
?>
