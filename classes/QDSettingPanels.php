<?php
class QDSettingPanels{
	static $allFiles = array();

	static function init(){
		self::recursPath(QD_PATH_3RD_JS.'desktop/'	,'qd_lib_local.3rd_js.desktop'	,'MyDesktop');
		if(is_array($GLOBALS['conf']['app']['settingPanels'])){
			foreach($GLOBALS['conf']['app']['settingPanels'] as $aSett){
				$aSett['path'] = preg_replace_callback('(\{\{(.*)\}\})', 'self::replaceConstant', $aSett['path']);
				self::recursPath($aSett['path'],$aSett['search'],$aSett['replace']);
			}
		}
		foreach(self::$allFiles as $kk=>$vv){
			self::$allFiles[$kk]=$vv;
		}
		return self::$allFiles;
	}

	static function replaceConstant(array $matches){
		if(defined($matches[1])){
			return constant($matches[1]);
		}else{
			return $matches[1];
		}
	}

	static function recursPath($path,$search,$repl){
		if(realpath($path)==''){
			return;
		}
		$t = glob(realpath($path).'/*',GLOB_ONLYDIR);
		foreach ($t as $v){
			if(preg_match('!\/SettingsPanels!',$v)){
				foreach (glob($v.'/*.js') as $vv){
					$vv = str_replace	(QD_PATH_ROOT	,''		,$vv);
					$vv = str_replace	('/'			,'.'	,$vv);
					$vv = str_replace	($search		,$repl	,$vv);
					$vv = preg_replace	('!\.js$!'		,''		,$vv);
					self::$allFiles[]=$vv;
				}
			}else{
				self::recursPath($v,$search,$repl);
			}
		}
	}

	function svc_getConfig(){
		$root	= $_REQUEST['root'];
		$aRoot	= explode('.',$root);
		$file	= array_shift($aRoot);
		$prms = json_decode(file_get_contents(QD_PATH_ROOT.'conf/'.$file.'.json'));
		header('content-type:text/html');
		//print "<pre>";
		//print CW_String::prettyPrint(json_encode(json_decode(file_get_contents(QD_PATH_ROOT.'conf/'.$file.'.json'))));
		foreach($aRoot as $k){
			$prms=$prms->$k;
		}

		if($_REQUEST['configType']=='array'){
			//db(array_combine(array_fill(0,count($prms),'val'),$prms));
			foreach($prms as $k=>$v){
				$prms[$k]=array('v'=>$v);
			}
		}
		return $prms;
	}
}
