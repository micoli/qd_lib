Ext.define('MyDesktop.App', {
	extend : 'Ext.ux.desktop.App',

	requires: [
		'Ext.window.MessageBox',
		'Ext.ux.desktop.ShortcutModel',
		'qd.system.systemStatus',
		'MyDesktop.genericModule',
		'MyDesktop.Settings',
		'MyDesktop.TrayClock',
		'MyDesktop.TrayConnections',
		'MyDesktop.TrayLogger',
		'Ext.chart.*',
		'Ext.fx.target.Sprite'
	],

	appItems	: [],
	autoExec	: [],
	extraInit	: function() {
	},

	init		: function() {
		var that = this;
		that.extraInit();

		Ext.each(that.appItems,function(v,k){
			v.text = v.title;
			v.windowId=v.xtype+'-'+v.title;
			v.appType = v.windowId;
		});
		that.on('ready',function(){
			// now ready...
			/*
			new MyDesktop.Settings({
				desktop: this.desktop
			}).show();
			 */
			for(i=0;i<that.autoExec.length;i++){
				var module = that.getModule(that.autoExec[i]);
				var win = module && module.createWindow();
				if (win) {
					win.show();
				}
			}
		});
		that.callParent.call(that);
	},

	getModules : function(){
		var modules = [
			//new MyDesktop.SystemStatus()
		];
		Ext.each(this.appItems,function(v,k){
			modules.push(new MyDesktop.genericModule(v));
		});

		//debugger;
		return modules;
	},

	getDesktopConfig: function () {
		var me = this, ret = me.callParent();
		var data = [];
		Ext.each(this.appItems,function(v,k){
			data.push({
				name	: v.title,
				iconCls	: v.iconCls?(v.iconCls=='auto'?'icon-app-'+v.xtype.replace(/\./g,'-'):v.iconCls):'cpu-shortcut',
				module	: v.windowId,
				appType	: v.windowId
			});
		});

		return Ext.apply(ret, {
			//cls				: 'ux-desktop-black',
			contextMenuItems: [{
				text			: 'Change Settings', handler: me.onSettings, scope: me
			}],
			shortcuts		: Ext.create('Ext.data.Store', {
				model			: 'Ext.ux.desktop.ShortcutModel',
				data			: data
			}),
			wallpaper		: QD_GBL_CONF.app.liburl+'/3rd_js/desktop/wallpapers/desktop2.jpg',
			wallpaperStretch: false
		});
	},

	// config for the start menu
	getStartConfig : function() {
		var me	= this;
		var ret	= me.callParent();
		return Ext.apply(ret, {
			title		: 'Media manager',
			iconCls		: 'user',
			height		: 300,
			toolConfig	: {
				width		: 100,
				items		: [{
					text	:'Settings',
					iconCls	:'settings',
					handler	: me.onSettings,
					scope	: me
				}]
			}
		});
	},

	getTaskbarConfig: function () {
		var ret = this.callParent();
		return Ext.apply(ret, {
			quickStart: [/*{
				name: 'Accordion Window',
				iconCls: 'accordion',
				module: 'acc-win'
			},{
				name: 'Grid Window',
				iconCls: 'icon-grid',
				module: 'grid-win'
			}*/],
			trayItems: [{
			//	xtype: 'traysabnzbd'	, flex: 1,text:'sabnzbd'
			//},'-',{
				xtype: 'traylogger'		, flex: 1,text:'logger'
			},'-',{
				xtype: 'trayconnections', flex: 1
			},'-',{
				xtype: 'trayclock'		, flex: 1
			}]
		});
	},

	onSettings: function () {
		var dlg = new MyDesktop.Settings({
			desktop: this.desktop
		});
		dlg.show();
	}
});