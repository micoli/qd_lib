Ext.define('MyDesktop.TrayConnections', {
	extend		: 'Ext.toolbar.TextItem',
	alias		: 'widget.trayconnections',
	cls			: 'ux-desktop-trayconnections',
	html		: '&#160;',
	tpl			: '{img}/{xhr}',

	initComponent: function () {
		var that = this;

		if (typeof(that.tpl) == 'string') {
			that.tpl = new Ext.XTemplate(that.tpl);
		}

		Ext.globalHandlerCounter = {
			'img'	: 0,
			'xhr'	: 0
		}
		Ext.globalAjaxHandler = function(event,request){
			if(event == 'imagestart'||event == 'imageend'){
				Ext.globalHandlerCounter['img'] += (event=="imagestart")?1:-1;
			}else{
				Ext.globalHandlerCounter['xhr'] += (event=="start")?1:-1;
			}
			var cmp = Ext.getCmp('qd.mediadb.ajaxCount')
			if(cmp){
				cmp.setText(''+Ext.globalHandlerCounter['xhr']+'/'+Ext.globalHandlerCounter['img']);
			}
		}

		that.callParent();
	},

	afterRender: function () {
		var that = this;
		Ext.Function.defer(that.updateTime, 100, that);
		that.callParent();
	},

	onDestroy: function () {
		var that = this;
		if (that.timer) {
			window.clearTimeout(that.timer);
			that.timer = null;
		}
		that.callParent();
	},

	updateTime: function () {
		var that = this;
		var text = that.tpl.apply(Ext.globalHandlerCounter);
		if (that.lastText != text) {
			that.setText(text);
			that.lastText = text;
		}
		that.timer = Ext.Function.defer(that.updateTime, 1000, that);
	}
});