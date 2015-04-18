<?php

include_once("./lib/files.php");

class userOperations
{
	private $file;
	private $labelBreak = "[BREAK]";
	private $labelName = "[NAME]=>";
	private $labelDescription = "[DESCRIPTION]=>";

	public function __construct(files $file)
	{
		$this->file = $file;
	}

	private function getContentFromFile()
	{
		return $this->file->readFile();
	}



	// private function findLabel($label, $content) {

	// }

	// public function getName() {
	// 	$content = $this->getContentFromFile();

	// 	if ($content != null && $content != "") {
	// 		$pos = strpos($content, $this->labelName);

	// 		if ($pos !== false) {
	// 			$posDescription = strpos($content, $this->labelDescription);

	// 			if ($posDescription !== false) {
	// 				return substr($content, strlen($this->labelName), ($posDescription - strlen($this->labelName)));
	// 			}
	// 		}
	// 	}
	// }

	// public function getDescription($isEdit = false) {
	// 	$content = $this->getContentFromFile();
	// 	if ($content != null && $content != "") {
	// 		$pos = strpos($content, $this->labelDescription);
	// 		if ($pos !== false) {
	// 			$description = substr($content, ($pos + strlen($this->labelDescription)));
	// 			$posBreak = strpos($content, $this->labelBreak);

	// 			if ($isEdit) {
	// 				if ($posBreak !== false) {
	// 					$description = explode($this->labelBreak, $description);
	// 				}
	// 			}

	// 			return is_array($description) ? $description : array($description);
	// 		}
	// 	}
	// }
}

?>