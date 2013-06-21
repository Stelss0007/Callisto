/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	tinymce.create('tinymce.plugins.sys_image', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('sys_image', function() {
				// Internal image object like a flash placeholder
				if (ed.dom.getAttrib(ed.selection.getNode(), 'class').indexOf('mceItem') != -1)
					return;

				ed.windowManager.open({
					file : url + '/image.htm',
					width : 480 + parseInt(ed.getLang('sys_image.delta_width', 0)),
					height : 385 + parseInt(ed.getLang('sys_image.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('image', {
				title : 'Вставить картинку',
				cmd : 'sys_image'
			});
		},

		getInfo : function() {
			return {
				longname : 'web core image',
				author : 'Alexandr Zherebilo',
				authorurl : 'http://webcore.ru',
				infourl : 'http://webcore.com',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('sys_image', tinymce.plugins.AdvancedImagePlugin);
})();