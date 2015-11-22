<?php
class QDExtLoader{
	static $confs=array();
	static $dependency=array();

	static function init(){
		self::$confs=array();
		self::$dependency=array();
	}

	static function loadFromConf(){
		if(array_key_exists('app', $GLOBALS['conf']) && array_key_exists('includes', $GLOBALS['conf']['app'])){
			if(array_key_exists('dir', $GLOBALS['conf']['app']['includes'])){
				foreach($GLOBALS['conf']['app']['includes']['dir'] as $v){
					self::loadDir($v);
				}
			}
			if(array_key_exists('pluginsDir', $GLOBALS['conf']['app']['includes'])){
				foreach($GLOBALS['conf']['app']['includes']['pluginsDir'] as $v){
					self::loadPluginsDir($v);
				}
			}
		}
	}
	static function loadModule($sConfFile){
		$oConf = json_decode(file_get_contents($sConfFile));
		$oConf->path=dirname($sConfFile);
		if(isset($oConf->js)){
			foreach($oConf->js as $k=>$sJsFile){
				$oConf->js[$k]=preg_replace('!\.js$!','',$sJsFile);
			}
		}
		$sConfName = str_replace('.load.json','',basename($sConfFile));
		self::$confs[$sConfName] = $oConf;
	}

	static function render(){
		self::$dependency=array();
		foreach(self::$confs as $sConfName=>$oConf){
			if(isset($oConf->require)){
				foreach($oConf->require as $k=>$sRequire){
					if (!array_key_exists($sRequire,self::$dependency)){
						self::$dependency[$sRequire]=array();
					}
					self::$dependency[$sRequire][]=$sConfName;
				}
			}
		}
		//print_r(self::$dependency);die();
		//print_r(self::$confs);die();
		foreach(self::$confs as $oConf){
			if(isset($oConf->css)){
				foreach($oConf->css as $sJsFile){
					print sprintf('<link rel="stylesheet" type="text/css"	href="%s/%s" />'."\n",$oConf->path,$sJsFile);
				}
			}
			if(isset($oConf->js)){
				foreach($oConf->js as $sCssFile){
					print sprintf('<script type="text/javascript" src="%s/%s.js"></script>'."\n",$oConf->path,$sCssFile);
				}
			}
		}
	}

	static function loadPluginsDir($path){
		foreach(glob($path.'*/*.load.json') as $module){
			self::loadModule($module);
		}
	}

	static function loadDir($path){
		foreach(glob($path.'*.load.json') as $module){
			self::loadModule($module);
		}
	}
}
