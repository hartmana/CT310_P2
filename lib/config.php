<?php

class config
{
	public $base_path;
	public $index;
	public $base_url;
	public $project_url = "/proj2";
	public $dev_name = "/~USER";

	public function __construct()
	{
		$this->base_path = $_SERVER['HTTP_HOST'];
		$this->base_url = $this->base_path . $this->dev_name . $this->project_url;
		$this->index = $this->base_path . "index.php";
	}
}

$config = new config();

?>