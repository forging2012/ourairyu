(function( $ ) {

$.ex = $.ex || {};
if ( $.ex.version ) {
	return;
}

$.extend( $.ex, {
	version: "@VERSION"
});

})( jQuery );