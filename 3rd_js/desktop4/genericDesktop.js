Ext.define('MyDesktop.genericDesktop', {
	extend: 'MyDesktop.App',

	requires: [
	],

	appItems  : [/*{
		title		: 'NZB'				,iconCls	:'auto',xtype	: 'qd.nzb.NZBPanel'			,id		: 'mainNZBPanel'
	}*/],

	//autoExec : ['qd.system.fileExplorer-File Explorer','qd.mediadb.indexer-File Indexer'],

	extraInit	: function() {
		/*Ext.each(QD_GBL_CONF.mediadb.helperSite,function(item){
			that.appItems.push({
				xtype		: 'simpleiframe',
				title		: item.title	,
				bodyBorder	: false			,
				src			: item.url		,
				iconCls		: item.iconCls?item.iconCls:''
			});
		});*/
	},

});