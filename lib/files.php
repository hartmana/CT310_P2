<?php
/*
 * Read and write in files
 * 
 * @author Felipe Volpatto	Feb 15, 2015
 */

include_once("./lib/config.php");

class files
{
	public $name;
	public $path;

	public function __construct($name)
	{
		global $config;
		$this->name = $name;
		//$this->path = $config->base_url . "/assets/users/" . $this->name . ".txt";
		$this->path = "assets/users/" . $this->name . ".txt";

	}

	public function exists()
	{
		return (file_exists($this->path));;
	}

	private function openFile($option)
	{

		if (!file_exists($this->path))
		{
			throw new Exception("File do not exist!");
			// $$file = fopen($this->path, "w");
		}

		$file = fopen($this->path, $option);

		return $file;
	}

	// public function readFile() {
	// 	try {
	// 		$file = $this->openFile("r");
	// 	} catch(Exception $e) {
	// 		return false;
	// 	}

	// 	$fileContents = "";

	// 	if (filesize($this->path) > 0)
	// 		$fileContents = fgetcsv($file);
	// 	print_r($fileContents);
	// 		//$fileContents = fread($file, filesize($this->path));
	//     fclose($file);

	// 	return $fileContents;
	// }

	// public function writeFile($content) {
	// 	print_r("WRITE FILE ");
	// 	$file = $this->openFile("w+");
	//     $result = fwrite($file, $content);
	//     fclose($file);

	// 	return $result !== FALSE;
	// }

	public function readFile()
	{
		try
		{
			$file = $this->openFile("r");
		}
		catch (Exception $e)
		{
			return false;
		}

		$fileContents = array();
		while (!feof($file))
		{
			$tmp = fgetcsv($file);
			if (!empty($tmp))
			{
				array_push($fileContents, $tmp);
			}
		}

		//print_r($fileContents);

		return $fileContents;
	}


	public function writeFile($content)
	{
		$file = $this->openFile("w+");
		foreach ($content as $value)
		{
			if ($value !== null || $value !== "")
			{
				$result = fputcsv($file, $value);
			}
		}
		return $result !== FALSE;
	}

}

?>