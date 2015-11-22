Ext.onReady(function(){
	Ext.Loader.setConfig({
		enabled			: true,
		disableCaching	: true,
		paths			: {
			'Ext'			: QD_GBL_CONF.app.liburl+'/3rd_js/extjs4',
			'Ext.ux'		: QD_GBL_CONF.app.liburl+'/3rd_js/ux',
			'Ext.ux.desktop': QD_GBL_CONF.app.liburl+'/3rd_js/desktop4/js',
			'MyDesktop'		: QD_GBL_CONF.app.liburl+'/3rd_js/desktop4',
			'Ext.modules'	: 'modules',
			'qd'			: 'modules/qd/',
			'modules'		: 'modules',
		}
	});

	Ext.require([
		'Ext.grid.*',
		'Ext.data.*',
		'Ext.util.*',
		'Ext.Action',
		'Ext.tab.*',
		'Ext.button.*',
		'Ext.form.*',
		'Ext.layout.*'
	]);

	Ext.require(QD_GBL_CONF.app.mainClass,function(){
		Ext.state.Manager.clear();
		Ext.state.Manager.setProvider(Ext.create('Ext.state.LocalStorageProvider'));

		(Ext.defer(function() {
			var hideMask = function () {
				Ext.get('loading').remove();
				Ext.fly('loading-mask').animate({
					opacity:0,
					remove:true
				});
			};

			document.getElementById('loading-msg').innerHTML = 'Initialization';
			var app = Ext.create(QD_GBL_CONF.app.mainClass);
			document.getElementById('loading-msg').innerHTML = 'Startup';
			var doResize = function() {
				var windowHeight = Ext.getDoc().getViewSize(false).height;

				var footerHeight  = 0;//footerEl.getHeight() + footerEl.getMargin().top,
					titleElHeight = 0;//titleEl.getHeight() + titleEl.getMargin().top,
					headerHeight  = 0;//headerEl.getHeight() + titleElHeight;

				var warnEl = Ext.get('fb');
				var warnHeight = warnEl ? warnEl.getHeight() : 0;

				var availHeight = windowHeight - ( footerHeight + headerHeight + 14) - warnHeight;
				var sideBoxHeight = 0;//sideBoxEl.getHeight();

				app.setHeight((availHeight > sideBoxHeight) ? availHeight : sideBoxHeight);
			};
			Ext.QuickTips.init();
			Ext.defer(hideMask, 250);
			if (app.setHeight){
				doResize();
			}
		},1500));
	});
});