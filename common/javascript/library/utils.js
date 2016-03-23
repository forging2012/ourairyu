(function() {

function extend() {
	var args = arguments, target = args[0], src = [].slice.call(args, 1),
		idx = 0, prop;
	
	if ( typeof target in { "object": 1, "function": 1 } ) {
		for ( ; idx < src.length; idx++ ) {
			for ( prop in src[idx] ) {
				if ( target[prop] === undefined ) {
					target[prop] = src[idx][prop];
				}
			}
		}
	}
}

extend( window.String.prototype, {
	/**
	 * 首字母大写
	 */
	capitalize: function() {
		return this.replace(/[a-z]+/ig, function( word ) { return word.charAt(0).toUpperCase() + word.substring(1).toLowerCase(); });
	},
	
	/**
	 * 驼峰式拼写
	 * 
	 * @param	<boolean>	isUpper			true - 大驼峰式
	 * 										false - 小驼峰式
	 */
	toCamelCase: function( isUpper ) {
		var result = this.capitalize().replace(/[^a-zA-Z0-9]*/g, "");
		
		if ( isUpper !== true ) {
			result = result.charAt(0).toLowerCase() + result.substring(1);
		}
		
		return result;
	},
	
	/**
	 * 填补字符串
	 * 
	 * @param	<int>		length			目标长度
	 * @param	<string>	placeholder		占位符，默认为空格（\x20）
	 * @param	<int>		position		0 - 在源字符串左边进行填补
	 * 										1 - 在源字符串右边进行填补
	 */
	pad: function( length, placeholder, position ) {
		var idx = 1, target = this, temp;
		
		if ( placeholder === null || placeholder === undefined ) {
			placeholder = "\x20";
		}
		
		temp = placeholder;
		length = length || 0;
		
		if ( this.length < length ) {
			for ( ; idx < length - this.length; idx++ ) {
				placeholder += temp;
			}
			
			target = position === 1 ? this + placeholder : placeholder + this;
		}
		
		return target.toString();
	},
	
	/**
	 * 进行 Unicode 转换
	 * 
	 * @return	<string>	转换过的以 \u 开头的十六进制 Unicode
	 */
	unicode: function() {
		var origin = this.toString(), target = new Array(), idx = 0;
		
		for ( ; idx < origin.length; idx++ ) {
			target.push( "\\u" + Number(origin[idx].charCodeAt(0)).toString(16).pad(4, '0').toUpperCase() );
		}
		
		return target.join("");
	}
});

extend( window.Number.prototype, {
	/**
	 * 补零
	 * 
	 * @param	<int>		digit			数字位数
	 */
	zerofill: function( digit ) {
		return String(this).pad(digit, "0");
	}
});

extend( window.Date.prototype, {
	format: function() {
		return this;
	}
});

})();