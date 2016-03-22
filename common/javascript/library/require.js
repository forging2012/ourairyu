(function() {

var require = function( files ) {
	var idx = 0, file;
	
	if ( files instanceof Array ) {
		for ( ; idx < files.length; ) {
			file = files[idx++];
			
			if ( typeof file === "string" ) {
				require.files.push( file );
			}
		}
	}
};
require.files = new Array();

function include() {
	if ( window.require.files ) {
		var idx = 0, files = window.require.files,
			body = window.document.body, script;
		
		for ( ; idx < files.length; ) {
			script = document.createElement("script");
			script.setAttribute("src", files[idx++]);
			body.appendChild(script);
		}
	}
}

if ( window.addEventListener ) {
	window.addEventListener("load", include, false);
}
else {
	window.attachEvent("onload", include);
}

window.require = require;

})();