<?php
class view{
	private $bluestats;
	private $theme;
	private $viewPath;
	private $appPath;

	private $page;

	public function __Construct($bluestats,$viewPath,$appPath)
	{
		$this->bluestats = $bluestats;
		$this->theme = $this->bluestats->theme;

		$this->viewPath = str_replace("{THEME}", $this->theme, $viewPath);
		$this->appPath = $appPath;

		$this->page = str_replace(array('/','.'), '', $this->bluestats->page);
	}

	public function error($code)
	{

	}

	public function render($type="GLOBAL")
	{
		
		if ($type == "GLOBAL") {
			$filePath = $this->viewPath."global.html";
		}else{
			$filePath = $this->viewPath."templates/{$this->page}.html";
		}

		if (file_exists($filePath)){
			/* Load template file */
			$string = file_get_contents($filePath);

			/* Modules */
			preg_match_all('/{{ ([^ ]+):([^ ]+) }}/', $string, $matches);

			foreach ($matches[0] as $key => $replaceStr) {

				/* Plugin Exist? */
				if (isset($this->bluestats->plugins[$matches[1][$key]])){
					/* Set plugin */
					$plugin = $this->bluestats->plugins[$matches[1][$key]];

					/* New module */
					$module = new module($this->bluestats->mysqli,$matches[1][$key],$matches[2][$key],$plugin,$this->theme,$this->appPath);
					/* Render the module */
				    $output = $module->render();

				    $string = str_replace($replaceStr, $output, $string);
				}else{
					$output = "Plugin not found: {$matches[1][$key]}";
					$string = str_replace($replaceStr, $output, $string);
				}
			}

			/* Page Content */
			if (strpos($string,'{{ content }}') !== false)
				$string = str_replace("{{ content }}", $this->render("page"), $string);
		}else{
			$string = $this->error(404);
		}
		return $string;
	}
	
}