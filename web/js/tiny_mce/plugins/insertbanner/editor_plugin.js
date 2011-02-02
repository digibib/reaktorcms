
(function() {
	tinymce.create('tinymce.plugins.InsertBannerPlugin', {
		init : function(ed, url) {
			ed.addCommand('mceInsertBanner', function() {
				return insertBannerMarkup();
			});

			ed.addButton('insertbanner', {
				title : 'Insert the banner image into the article',
				cmd : 'mceInsertBanner',
				image : url + '/img/insertbanner.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('insertbanner', n.nodeName == 'IMG');
			});
		},

		getInfo : function() {
			return {
				longname : 'Insert banner image plugin',
				author : 'Hannes Magnusson',
				authorurl : 'http://linpro.no',
				version : "0.9"
			};
		}
	});

	tinymce.PluginManager.add('insertbanner', tinymce.plugins.InsertBannerPlugin);
})();

