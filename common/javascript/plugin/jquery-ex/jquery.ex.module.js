(function( $ ) {

$.module = function( name, base, prototype ) {
	var namespace = name.split(".")[0],
		name = name.split(".")[1],
		fullName = namespace + "-" + name;
		
	if ( !prototype ) {
		prototype = base;
		base = $.Module;
	}
	
	// create selector for plugin
	$.expr[ ":" ][ fullName ] = function ( elem ) {
		return !!$.data( elem, name );
	}
	
	$[ namespace ] = $[ namespace ] || {};
	$[ namespace ][ name ] = function( options, element ) {
		if ( arguments.length ) {
			this._createModule( options, element );
		}
	}
	
	var basePrototype = new base();
	basePrototype.options = $.extend( true, {}, basePrototype.options );
	
	$[ namespace ][ name ].prototype = $.extend( true, basePrototype, {
		namespace: namespace,
		moduleName: name,
		moduleEventPrefix: $[ namespace ][ name ].prototype.moduleEventPrefix || ( namespace + name ),
		moduleBaseClass: fullName
	}, prototype );
	
	$.module.link( name, $[ namespace ][ name ] );
};

$.module.link = function( name, object ) {
	$.fn[ name ] = function( options ) {
		var isMethodCall = typeof( options ) === "string",
			args = Array.prototype.slice.call( arguments, 1 ),
			returnValue = this;
			
		options = !isMethodCall && args.length ?
			$.extend.apply( null, [ true, options ].concat( args ) ):
			options;
		
		if ( isMethodCall && options.charAt( 0 ) === "_" ) {
			return undefined;
		}
		
		if ( isMethodCall ) {
			this.each(function() {
				var instance = $.data( this, name ),
					methodValue = instance && $.isFunction( instance[ options ] ) ?
					instance[ options ].apply( instance, args ) :
					instance;
					
				if ( methodValue != instance && methodValue != undefined ) {
					returnValue = methodValue;
					return false;
				}
			});
		}
		else {
			this.each(function() {
				var instance = $.data( this, name );
				
				if ( instance ) {
					instance.options( options || {} )._init();
				}
				else {
					$.data( this, name, new object( options, this ) );
				}
			});
		}
		
		return returnValue;
	};
};

$.Module = function( options, element ) {
	if ( arguments.length ) {
		this._createModule( options, element );
	}
};

$.Module.prototype = {
	moduleName: "module",
	moduleEventPrefix: "",
	options: {},
	destroy: function() {
		this.element
			.unbind( "." + this.moduleName )
			.removeData( this.moduleName );
			
		this.module()
			.unbind( "." + this.moduleName );
	},
	module: function() {
		return this.element;
	},
	option: function( key, value ) {
		var options = key;
		
		if ( arguments.length === 0 ) {
			return $.extend( {}, this.options );
		}
		
		if ( typeof( key ) === "string" ) {
			if ( value === undefined ) {
				return this.options[ key ];
			}
			
			options = {};
			options[ key ] = value;
		}
		
		this._setOptions( options );
		
		return this;
	},
	_createModule: function( options, element ) {
		$.data( element, this.moduleName, this );
		this.element = $( element );
		this.options = $.extend( true, {},
			this.options,
			options );
			
		var self = this;
		this.element.bind( "remove." + this.moduleName, function() {
			self.destroy();
		});
		
		this._create();
//		this._trigger( "create" );
		this._init();
	},
	_create: function() {},
	_init: function() {},
	_trigger: function( type, event, data ) {
		var callback = this.options[ type ];
		
		event = $.Event( event );
		event.type = ( type === this.moduleEventPrefix ?
			type :
			this.moduleEventPrefix + type ).toLowerCase();
		data = data || {};
		
		if ( event.originalEvent ) {
			for ( var i = $.event.props.length, prop; i; ) {
				prop = $.event.props[ --i ];
				event[ prop ] = event.originalEvent[ prop ];
			}
		}
		
		this.element.trigger( event, data );
		
		return !( $.isFunction( callback ) &&
			callback.call( this.element[ 0 ], event, data ) === false ||
			event.isDefaultPrevented() );
	},
	_setOptions: function( options ) {
		var self = this;
		
		$.each( options, function( key, value ) {
			self._setOption( key, value );
		});
		
		return this;
	},
	_setOption: function( key, value ) {
		this.options[ key ] = value;
		
		return this;
	},
	_preposeNewClass: function( className ) {
		this.addClass(function( index, classNames) {
			$( this ).removeClass();
			
			return ( $.trim( classNames ) === "" ? className : className + " " + classNames );
		});
	},
	_transformSpecialChar: function( string ) {
		return String( string ).replace(/\>/g, "&gt;").replace(/\</g, "&lt;").replace(/\"/g, "&quot;").replace(/\'/g, "&#039;");
	}
};

})( jQuery );