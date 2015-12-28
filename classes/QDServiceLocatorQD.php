<?php
class QDServiceLocatorQD implements QDLocator{
	protected $base = '.';
	protected $initialized=false;

	public function __construct($directory='.'){
		$this->base = (string) $directory;
		if(defined('QDBASE')){
			$this->base = QDBASE;
		}

	}

	private function init(){
		if(!$this->initialized){
			$this->initialized=true;
			$this->arrModules = array();
			$this->recursPath($this->base.'/modules');
			if(defined('QD_PATH_MODULES')){
				$this->recursPath(QD_PATH_MODULES);
				$this->recursPath(QD_PATH_MODULES.'/modules');
			}
			array_unshift($this->arrModules,realpath($this->base.'/classes'));
			array_unshift($this->arrModules,realpath($this->base.'/3rd_php'));
		}
	}

	public function canLocate($class){
		$path = $this->getPath($class);
		return file_exists($path);
	}

	function recursPath($path){
		//print $path.'<br>';
		$t = glob($path.'/*',GLOB_ONLYDIR);
		foreach ($t as $v){
			$p = realpath($v);
			if(preg_match('!\/classes!',$v)){
				$this->arrModules[]=$p;
			}else{
				$this->recursPath($v);
			}
		}
	}

	public function getPath($class){
		$this->init();
		$rtn='';
		foreach ($this->arrModules as $k){
			if (file_exists($k.'/'.$class.'.php')){
				$rtn = $k.'/'.$class.'.php';
				break;
			}
			//namespaceClassName
			$simpleClass=explode('\\',$class);
			$simpleClass=array_pop($simpleClass);
			//db(array_pop(explode('\\',$class))."####".$k.'/'.$class.'.php'."####".file_exists($k.'/'.$class.'.php'));
			if (file_exists($k.'/'.$simpleClass.'.php')){
				$rtn = $k.'/'.$simpleClass.'.php';
				break;
			}
		}
		return $rtn;
	}
}

QDServiceLocator::attachLocator(new QDServiceLocatorQD(), 'QD');
