<?php
class error{
	public $error_code;
	public $error;
	private $bluestats;
	private $theme;

	public function _Construct($error_code,$bluestats)
	{
		$this->error_code = $error_code;
		$this->bluestats = $bluestats;
		$this->theme = $this->bluestats->theme;
	}
}