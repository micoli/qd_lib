<?php
//session_start();

class QDSvc{
	protected static $object = array();

	function addClass($id,&$obj){
		self::$object[$id] = $obj;
	}

	function getObj($id){
		return self::$object[$id];
	}

	static function run(){
		global $argv;
		if(defined('SMF_COMPATIBLE')&&SMF_COMPATIBLE){
			$smfCompatible=true;
		}else{
			$smfCompatible=false;
		}
		date_default_timezone_set('Europe/Paris');
		if(isset($argv)){
			$_SERVER['SERVER_NAME']='local';
			foreach ($argv as $k=>$arg){
				if ($k>0){
					$t = explode("=",$arg,2);
					$_REQUEST[$t[0]]=$t[1];
				}
			}
		}
		error_reporting(E_ERROR | E_WARNING | E_PARSE );
		if ($_REQUEST['exw_action']){
			$arrArg		= explode('.',$_REQUEST['exw_action']);
			$mode='qd';
			if($smfCompatible){
				$objId		= 'svc'.ucfirst($arrArg[1]);
				$methodName	= $arrArg[2];
				$mode='smf';
				if(!class_exists($objId)){
					$objId		= $arrArg[0];
					$methodName	= $arrArg[1];
					$mode='qd';
				}
			}else{
				$objId		= $arrArg[0];
				$methodName	= $arrArg[1];
				$mode='qd';
			}

			self::$object[$objId] = new $objId();
			$execMethodName = ($mode=='qd'?'svc_':'pub_').$methodName;
			if (!in_array($execMethodName,get_class_methods (get_class  (self::$object[$objId])))){
				print 'method <b>'.$execMethodName.'</b> not in session object <b>'.$objId.'</b> of class <b>'.get_class  ($objId).'</b>';
				return;
			}
			$output_mode = strtolower(array_key_exists_assign_default('output_mode', $_REQUEST, 'json'));

			switch ($output_mode){
				case 'json' :
					header("Content-Type: application/json; charset: UTF-8",true);
				break;
				case 'html' :
					header('content-type:text/html');
				break;
				case 'htmltable' :
					header('content-type:text/html');
				break;
			}

			if($mode!='qd'){
				$result = call_user_func(array(self::$object[$objId],$execMethodName),$_REQUEST);
			}else{
				$result = call_user_func(array(self::$object[$objId],$execMethodName));
			}

			switch ($output_mode){
				case 'json' :
					$result = json_encode($result,JSON_PRETTY_PRINT);
				break;
				case 'html' :
				break;
				case 'htmltable' :
					$result = QDMisc::array2htmltable(array_key_exists('htmltablekey',$_REQUEST)?$result[$_REQUEST['htmltablekey']]:$result);
				break;
			}
			die($result);
		}
	}
}
