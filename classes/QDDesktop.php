<?php
class QDDesktop {
	private static function addJS($url){
		return '<script type="text/javascript" src="'.$url.'"></script>';

	}

	private static function addCSS($url){
		return '<link rel="stylesheet" type="text/css" href="'.$url.'" />';
	}

	public static function desktop_head(){
		$liburl = $GLOBALS['conf']['app']['liburl']?$GLOBALS['conf']['app']['liburl']:'lib';
		$aS  = array();
		$aS[]= '	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
		$aS[]= '	<title>'.str_replace(' ','&nbsp;',$GLOBALS['conf']['app']['title']).'</title>';
		$aS[]= '		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">';
		$aS[]= 			self::addCSS($liburl.'/skins/4/css/loader.css');
		$aS[]= '		<style type="text/css">';
		$aS[]= '			.x-grid3-row td{';
		$aS[]= '				-moz-user-select	:text;';
		$aS[]= '			}';
		$aS[]= '			.ext-strict .ext-ie .x-tree .x-panel-bwrap{';
		$aS[]= '				position:relative;';
		$aS[]= '				overflow:hidden;';
		$aS[]= '			}';
		$aS[]= '		</style>';
		return join("\n",$aS);
	}

	public static function desktop4_init(){
		$liburl = $GLOBALS['conf']['app']['liburl']?$GLOBALS['conf']['app']['liburl']:'lib';
		$aS  = array();
		$aS[]= '	<div id="loading-mask" style=""></div>';
		$aS[]= '	<div id="loading">';
		$aS[]= '		<div class="loading-indicator">';
		$aS[]= '			<h1>'.str_replace(' ','&nbsp;',$GLOBALS['conf']['app']['title']).'</h1>';
		$aS[]= '			<img src="'.$liburl.'/'.str_replace(' ','&nbsp;',$GLOBALS['conf']['app']['loaderImg']).'" />';
		$aS[]= '			<span id="loading-msg">Loading styles and images...</span>';
		$aS[]= '		</div>';
		$aS[]= '	</div>';

		$aS[]= self::addCSS($liburl.'/skins/4/resources/css/ext-all.css');
		$aS[]= self::addCSS($liburl.'/skins/4/css/icons.css');
		$aS[]= self::addCSS($liburl.'/skins/4/css/body.css');
		$aS[]= self::addCSS($liburl.'/3rd_js/desktop4/css/desktop.css');
		$aS[]= self::addCSS($liburl.'/skins/4/css/CheckHeader.css');
		$aS[]= self::addCSS($liburl.'/skins/flags/language-flags/icons.css');

		$aS[]= '	<script type="text/javascript">';
		$aS[]= '		document.getElementById("loading-msg").innerHTML = "Loading Core API...";';
		$aS[]= '	</script>';

		$aS[]= self::addJS($liburl.'/3rd_js/extjs4/bootstrap.js');
		$aS[]= self::addJS($liburl.'/3rd_js/startup4.js');

		$aS[]= '	<script type="text/javascript">';
		$aS[]= '		document.getElementById("loading-msg").innerHTML = "Loading Extensions";';
		$aS[]= '		var QD_GBL_CONF				='.json_encode($GLOBALS['conf']).';';
		$aS[]= '		var QD_GBL_SETTING_PANELS	='.json_encode(QDSettingPanels::init()).';';
		$aS[]= '	</script>';

		$aS[]= self::addJS($liburl.'/3rd_js/commonfunctions.js');
		$aS[]= self::addJS($liburl.'/3rd_js/css.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/SelectGrouping.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/Ext.data.ConnectionEx.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/Ext.AjaxEx.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/AjaxEx.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/SimpleIFrame.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/thumbnailSelector.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/CheckColumn.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/QTPreview.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/base64.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/array.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/ImageSelector.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/DataView/LabelEditor.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/DataView/DragSelector.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/Notification.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/FileBrowser.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/grid/feature/Tileview.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/grid/plugin/DragSelector.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/container/ButtonSegment.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/container/SwitchButtonSegment.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/folderPicker.js');

		$aS[]= self::addJS($liburl.'/3rd_js/stomp/ReconnectingSockJS.js');
		$aS[]= self::addJS($liburl.'/3rd_js/stomp/ReconnectingWebSocket.js');
		$aS[]= self::addJS($liburl.'/3rd_js/stomp/sockjs-0.3.min.js');
		$aS[]= self::addJS($liburl.'/3rd_js/stomp/stomp.js');

		$aS[]= self::addCSS($liburl.'/3rd_js/ux/grid/feature/Tileview.css');
		$aS[]= self::addCSS($liburl.'/3rd_js/ux/container/ButtonSegment.css');
		$aS[]= '	<script type="text/javascript">';
		$aS[]= '		document.getElementById("loading-msg").innerHTML = "Loading Application";';
		$aS[]= '	</script>';

		/*
		$aS[]= self::addJS($liburl.'/3rd_js/extjs4.old/src/layout/container/AbstractFit.js');

		$aS[]= self::addJS('modules/qd/mediadb/serieEditor.js');
		$aS[]= self::addJS('modules/qd/mediadb/seriePanel.js');
		$aS[]= self::addJS('modules/qd/mediadb/serieFileSorter.js');
		$aS[]= self::addJS('modules/qd/mediadb/serieFileSorterConfirmation.js');
		$aS[]= self::addJS('modules/qd/sabnzbd/sabnzbdPanel.js');
		$aS[]= self::addJS('modules/qd/mediadb/movieQTPreview.js');
		$aS[]= self::addJS('modules/qd/mediadb/movieEditor.js');
		$aS[]= self::addJS('modules/qd/mediadb/moviePanel.js');
		$aS[]= self::addJS('modules/qd/nzb/nzbview.js');
		$aS[]= self::addJS('modules/qd/nzb/feeditemdesc.js');
		$aS[]= self::addJS('modules/qd/nzb/feedtab.js');
		$aS[]= self::addJS('modules/qd/nzb/NZBPanel.js');
		$aS[]= self::addJS('modules/qd/mediadb/app.js');
		$aS[]= self::addJS('modules/qd/system/fileExplorer.js');
		$aS[]= self::addJS('modules/qd/mediadb/indexer.js');
		$aS[]= self::addJS('modules/qd/mediadb/xbmcDB.js');
		$aS[]= self::addJS('modules/qd/mediadb/xbmcDBSeriesPanel.js');
		*/
		return join("\n",$aS);
	}

	public static function desktop4_head(){
		return self::desktop_head();
	}

	public static function desktop5_head(){
		return self::desktop_head();
	}

	public static function desktop5_init(){
		$liburl = $GLOBALS['conf']['app']['liburl']?$GLOBALS['conf']['app']['liburl']:'lib';
		$aS  = array();
		$aS[]= '	<div id="loading-mask" style=""></div>';
		$aS[]= '	<div id="loading">';
		$aS[]= '		<div class="loading-indicator">';
		$aS[]= '			<h1>'.str_replace(' ','&nbsp;',$GLOBALS['conf']['app']['title']).'</h1>';
		$aS[]= '			<img src="'.$liburl.'/'.str_replace(' ','&nbsp;',$GLOBALS['conf']['app']['loaderImg']).'" />';
		$aS[]= '			<span id="loading-msg">Loading styles and images...</span>';
		$aS[]= '		</div>';
		$aS[]= '	</div>';

		$aS[]= self::addCSS($liburl.'/skins/resources/5/css/ext-all.css');
		$aS[]= self::addCSS($liburl.'/skins/css/icons.css');
		$aS[]= self::addCSS($liburl.'/skins/css/body.css');
		$aS[]= self::addCSS($liburl.'/3rd_js/desktop5/css/desktop.css');
		$aS[]= self::addCSS($liburl.'/skins/css/CheckHeader.css');
		$aS[]= self::addCSS($liburl.'/skins/flags/language-flags/icons.css');

		$aS[]= '	<script type="text/javascript">';
		$aS[]= '		document.getElementById("loading-msg").innerHTML = "Loading Core API...";';
		$aS[]= '	</script>';

		$aS[]= self::addJS($liburl.'/3rd_js/extjs5/bootstrap.js');
		$aS[]= self::addJS($liburl.'/3rd_js/startup5.js');

		$aS[]= '	<script type="text/javascript">';
		$aS[]= '		document.getElementById("loading-msg").innerHTML = "Loading Extensions";';
		$aS[]= '		var QD_GBL_CONF				='.json_encode($GLOBALS['conf']).';';
		$aS[]= '		var QD_GBL_SETTING_PANELS	='.json_encode(QDSettingPanels::init()).';';
		$aS[]= '	</script>';

		$aS[]= self::addJS($liburl.'/3rd_js/commonfunctions.js');
		$aS[]= self::addJS($liburl.'/3rd_js/css.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/SelectGrouping.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/Ext.data.ConnectionEx.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/Ext.AjaxEx.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/AjaxEx.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/SimpleIFrame.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/thumbnailSelector.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/CheckColumn.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/QTPreview.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/base64.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/array.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/ImageSelector.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/DataView/LabelEditor.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/DataView/DragSelector.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/Notification.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/FileBrowser.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/grid/feature/Tileview.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/grid/plugin/DragSelector.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/container/ButtonSegment.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/container/SwitchButtonSegment.js');
		$aS[]= self::addJS($liburl.'/3rd_js/ux/folderPicker.js');

		$aS[]= self::addJS($liburl.'/3rd_js/stomp/ReconnectingSockJS.js');
		$aS[]= self::addJS($liburl.'/3rd_js/stomp/ReconnectingWebSocket.js');
		$aS[]= self::addJS($liburl.'/3rd_js/stomp/sockjs-0.3.min.js');
		$aS[]= self::addJS($liburl.'/3rd_js/stomp/stomp.js');

		$aS[]= self::addCSS($liburl.'/3rd_js/ux/grid/feature/Tileview.css');
		$aS[]= self::addCSS($liburl.'/3rd_js/ux/container/ButtonSegment.css');
		$aS[]= '	<script type="text/javascript">';
		$aS[]= '		document.getElementById("loading-msg").innerHTML = "Loading Application";';
		$aS[]= '	</script>';

		/*
		$aS[]= self::addJS($liburl.'/3rd_js/extjs4.old/src/layout/container/AbstractFit.js');

		$aS[]= self::addJS('modules/qd/mediadb/serieEditor.js');
		$aS[]= self::addJS('modules/qd/mediadb/seriePanel.js');
		$aS[]= self::addJS('modules/qd/mediadb/serieFileSorter.js');
		$aS[]= self::addJS('modules/qd/mediadb/serieFileSorterConfirmation.js');
		$aS[]= self::addJS('modules/qd/sabnzbd/sabnzbdPanel.js');
		$aS[]= self::addJS('modules/qd/mediadb/movieQTPreview.js');
		$aS[]= self::addJS('modules/qd/mediadb/movieEditor.js');
		$aS[]= self::addJS('modules/qd/mediadb/moviePanel.js');
		$aS[]= self::addJS('modules/qd/nzb/nzbview.js');
		$aS[]= self::addJS('modules/qd/nzb/feeditemdesc.js');
		$aS[]= self::addJS('modules/qd/nzb/feedtab.js');
		$aS[]= self::addJS('modules/qd/nzb/NZBPanel.js');
		$aS[]= self::addJS('modules/qd/mediadb/app.js');
		$aS[]= self::addJS('modules/qd/system/fileExplorer.js');
		$aS[]= self::addJS('modules/qd/mediadb/indexer.js');
		$aS[]= self::addJS('modules/qd/mediadb/xbmcDB.js');
		$aS[]= self::addJS('modules/qd/mediadb/xbmcDBSeriesPanel.js');
		*/
		return join("\n",$aS);
	}
}
?>