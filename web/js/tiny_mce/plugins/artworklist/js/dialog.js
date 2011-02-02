var ArtworklistDialog = {
	init : function() {
		var f = document.forms[0];
	},

	insert : function(what) {
		tinyMCEPopup.getWin().injectArtwork(what);
		tinyMCEPopup.close();
	}
};


