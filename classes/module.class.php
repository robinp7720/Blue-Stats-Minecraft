<?php
class module{
	private $config = array();
	private $page = "";

	function __construct ($config,$page,$module){
		$this->page = $page;
		$this->config = $config;
	}
}