/*!
 * JavaScript Development Kit
 * 
 * Copyright 2012, Ourai Lam
 * 
 * Date: Fri Dec 21 ‏‎21:22:50 2012
 */
(function( window ) {
	
if ( window.jQuery === undefined ) {
	alert("Please include the jQuery Library.");
}

var win = window,
	$ = win.jQuery
	_T = {};

$.extend( _T, {
	/**
	 * 别名
	 * 
	 * @method	alias
	 * @param	{String} alias
	 * @return
	 */
	alias: function( alias ) {
		if ( $.type( alias ) === "string" ) {
			if ( win[alias] === undefined ) {
				win[alias] = this;
			}
			else {
				alert( "Fail to name alias! '" + alias + "' has already existed!" );
			}
		}
		
		return win[String(alias)];
	},

	/**
	 * 将其他组件组装到核心对象上
	 * 
	 * @method	connect
	 * @param	{String} namespace
	 * @param	{Object} target
	 * @return
	 */
	connect: function( namespace, target ) {
		var host = this;
		
		// 附加到主对象上
		if ( $.isPlainObject( namespace ) ) {
			target = namespace;
		}
		// 附加到命名空间上
		else if ( $.type( namespace ) === "string" ) {
			if ( this[namespace] === undefined ) {
				this[namespace] = {};
			}
			
			host = this[namespace];
		}
		
		if ( $.isPlainObject( target ) ) {
			$.extend( host, target );
		}
		
		return this;
	},
	
	/**
	 * 打印信息
	 * 
	 * @method	log
	 * @param	{Variant} message
	 * @return
	 */
	log: function( message ) {
		var isObject = $.isPlainObject( message ),
			key;
		
		// 打印到控制台中
		if ( window.console ) {
			if ( isObject ) {
				window.console.dir( message );
			}
			else {
				window.console.log( message );
			}
		}
		// 打印到页面
		else {
			if ( isObject ) {
				for ( key in message ) {
					try {
						document.write( key + ": " + message[key] );
					}
					catch( e ) {
						document.write( "Exception variant key: " + message[key] );
					}
					
					document.write( "<br>" );
				}
			}
			else {
				document.write( message );
				document.write( "<br>" );
			}
		}
	},
	
	/**
	 * 判断是否为空变量
	 * 空变量 - null, undefined, "", '', 0, '0', "0", [], {}
	 * 
	 * @method	empty
	 * @param	{Variant} target
	 * @return	{Boolean}
	 */
	empty: function( target ) {
		return $.isArray( target ) ? target.length === 0 :
			$.isPlainObject( target ) ? $.isEmptyObject() :
			$.inArray( target, [null, undefined, "", 0, "0"] ) > -1;
	},
	
	/**
	 * 获取变量类型
	 * 
	 * @method	type
	 * @param	{Variant} source
	 * @return	{String}
	 */
	type: $.type || function( source ) {
		
	},
	
	/**
	 * 判断是否为数字或数字类型字符串
	 * 
	 * @method	isNumeric
	 * @param	{Variant} target
	 * @return	{Boolean}
	 */
	isNumeric: function( target ) {
		return $.isFunction( $.isNumeric ) ? $.isNumeric( target ) :
			!isNaN( parseFloat(target) ) && isFinite( target );
	},
	
	/**
	 * 将字符串转换为驼峰式
	 * 
	 * @method	camelCase
	 * @param	{String} string
	 * @param	{Boolean} isUpper
	 * @return	{String}
	 */
	camelCase: function( string, isUpper ) {
		if ( this.type( string ) === "string" ) {
			string = string.toLowerCase().replace( /[-_\x20]\w?/g, function( c, i ) {
				return c.charAt(1).toUpperCase();
			});
			
			// 转换为小驼峰式（首字母小写）
			if ( isUpper !== true ) {
				string = string.charAt(0).toLowerCase() + string.slice(1);
			}
		}
		
		return string;
	},
	
	/**
	 * 首字母大写
	 * 
	 * @method	capitalize
	 * @param	{String} string
	 * @return	{String}
	 */
	capitalize: function( string ) {
		return this.type(string) !== "string" ? null : string.replace(/[a-z]+/ig, function( word ) {
			return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
		});
	},
	
	/**
	 * 填补
	 * 
	 * @method	pad
	 * @param	{Variant} target
	 * @param	{Integer} length
	 * @param	{String} placeholder
	 * @param	{Integer} position
	 * @return	{String}
	 */
	pad: function( target, length, placeholder, position ) {
		var idx = 1,
			temp;
		
		target = String(target);
		
		// 占位符默认为空格
		if ( placeholder === null || placeholder === undefined ) {
			placeholder = "\x20";
		}
		
		temp = placeholder;
		length = length || 0;
		
		// 添加占位符
		if ( target.length < length ) {
			for ( ; idx < length - target.length; idx++ ) {
				placeholder += temp;
			}
			// 默认把占位符添加到左侧（1 为右侧）
			target = position === 1 ? target + placeholder : placeholder + target;
		}
		
		return target;
	},
	
	/**
	 * 补零（前导零）
	 * 
	 * @method	zerofill
	 * @param	{Integer} target
	 * @param	{Integer} digit
	 * @return	{String}
	 */
	zerofill: function( target, digit ) {
		if ( this.isNumeric(target) && this.isNumeric(digit) ) {
			target = this.pad(target, Number(digit), "0");
		}
		else {
			target = null;
		}
		
		return target;
	},
	
	/**
	 * 转换成 Unicode（以 \u 开头的十六进制）
	 * 
	 * @method	unicode
	 * @param	{String} string
	 * @return	{String}
	 */
	unicode: function( string ) {
		var unicode = [],
			idx = 0;
		
		if ( this.type(string) === "string" ) {
			for ( ; idx < string.length; idx++ ) {
				unicode.push("\\u" + this.pad(Number(string[idx].charCodeAt(0)).toString(16), 4, "0").toUpperCase());
			}
			
			unicode = unicode.join("");
		}
		else {
			unicode = null;
		}
		
		return unicode;
	},
	
	/**
	 * 解析并返回 URL 的各部分信息 
	 * 
	 * @method	parseURL
	 * @param	{String} url
	 * @param	{Array} protocolList
	 * @return	{JSON}
	 */
	parseURL: function( url, protocolList ) {
		var result = null,
			rHost = /^([\w-]+\.)+?[\w-]+?$/,
			rIP = /^(([1-9]?\d|(1\d{2}|2([0-4]\d|5[0-5])))\.?){3}([1-9]?\d|(1\d{2}|2([0-4]\d|5[0-5])))(:\d{1,5})?$/,
			attr_key, attr_val, link, host, protocol;
		
		if ( $.type(url) === "string" ) {
			host = url.split("/")[0];
			
			// 所传字符串是域名格式时默认为 HTTP 协议
			if ( rHost.test(host) || rIP.test(host) ) {
				url = "http:\/\/" + url;
			}
			
			link = document.createElement( "a" );
			link.href = url;
			result = {};
			
			// 遍历 Link DOM 的属性
			for ( attr_key in link ) {
				// 捕获 IE9- 中有的属性所造成的异常
				try {
					attr_val = link[attr_key];
					
					// 只获取 Location 对象中存在的属性
					if ( $.type(attr_val) === "string" && location[attr_key] !== undefined ) {
						result[attr_key] = attr_val;
					}
				}
				catch( e ) {
					_T.log( attr_key );
				}
			}
			
			protocol = result.protocol;
			
			if ( $.isArray(protocolList) === false ) {
				protocolList = [];
			}
			
			// 默认禁止 JavaScript 与 data URI 协议
			protocolList.push( "javascript" );
			protocolList.push( "data" );
			
			result.params = {};
			// 将 hash 转化为对象
			if ( result.hash ) {
				$.each( result.hash.slice(1).split("&"), function( idx, pair ) {
					pair = pair.split("=");
					
					if ( pair.length === 2 ) {
						result.params[pair[0]] = pair[1];
					}
				});
			}
			
			// 协议为空值（undefined 及 null）或在禁止协议列表中
			if ( $.type(protocol) !== "string" || (new RegExp(("^" + protocolList.join("|")), "i")).test(protocol) ) {
				result = null;
			}
		}
		
		return result;
	}
});

if ( win.JSDK === undefined ) {
	win.JSDK = {};
}

$.extend( true, win.JSDK, _T );
	
})( window );