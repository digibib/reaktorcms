
(function() {
	tinymce.create('tinymce.plugins.ArtworkListPlugin', {
		init : function(ed, url) {
			ed.addCommand('mceArtworkList', function() {
				ed.windowManager.open({
					file : 'browse/artworks/' + document.getElementById("popup_id").value,
					width : 620 + parseInt(ed.getLang('artworklist.delta_width', 0)),
					height : 420 + parseInt(ed.getLang('artworklist.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register artworklist button
			ed.addButton('artworklist', {
				title : 'Link artwork to article',
				cmd : 'mceArtworkList',
				image : url + '/img/artworklist.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('artworklist', n.nodeName == 'IMG');
			});
		},

		getInfo : function() {
			return {
				longname : 'Artwork list plugin',
				author : 'Hannes Magnusson',
				authorurl : 'http://linpro.no',
				version : "0.9"
			};
		}
	});

	tinymce.PluginManager.add('artworklist', tinymce.plugins.ArtworkListPlugin);
})();

