/*
	字符串缓存对象
*/
function StringBuffer() {
	this._strings = new Array();
}

StringBuffer.prototype = {
	append: function(string) {
		this._strings.push(string);
	},
	reverse: function() {
		this._strings.reverse();
	},
	toString: function() {
		return this._strings.join("");
	}
}