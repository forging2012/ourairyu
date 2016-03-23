(function( window ) {
	
var _T = window.JSDK,
	// 节点类型
	NODE_ELEMENT = 1,
	NODE_ATTRIBUTE = 2,
	NODE_TEXT = 3;

//	ELEMENT_NODE: 1
//	ATTRIBUTE_NODE: 2
//	TEXT_NODE: 3
//	CDATA_SECTION_NODE: 4
//	ENTITY_REFERENCE_NODE: 5
//	ENTITY_NODE: 6
//	PROCESSING_INSTRUCTION_NODE: 7
//	COMMENT_NODE: 8
//	DOCUMENT_NODE: 9
//	DOCUMENT_TYPE_NODE: 10
//	DOCUMENT_FRAGMENT_NODE: 11
//	NOTATION_NODE: 12
	
if ( _T && _T.connect ) {
	
_T.connect({
	/**
	 * 获取 DOM 集合
	 * 
	 * @method	doms
	 * @param	{Variant} target	待解析的目标
	 * @return	{Array}
	 */
	doms: function( target ) {
		var doms = [],
			constructor;
		
		if ( _T.empty( target ) === false ) {
			constructor = target.constructor;
			
			// jQuery 对象
			if ( constructor === window.jQuery ) {
				doms = target.toArray();
			}
			// 单个 DOM
			else if ( target.nodeType === NODE_ELEMENT ) {
				doms.push( target );
			}
			// 列表
			else if ( target.length ) {
				doms = [].slice.call( target, 0 );
			}
		}
		
		return doms;
	},
	
	/**
	 * 获取 DOM 的「data-*」属性集
	 * 
	 * @method	dataset
	 * @param	{DOM/jQuery DOM} dom
	 * @return	{JSON}
	 */
	dataset: function( dom ) {
		var that = this,
			dataAttrs = {};
		
		dom = that.doms(dom).shift();
		
		if ( _T.empty( dom ) === false && dom.nodeType === NODE_ELEMENT ) {
			// 支持 DOM 的 dataset
			if ( $.isPlainObject( dom.dataset ) ) {
				dataAttrs = dom.dataset;
			}
			// 支持 DOM 的 outerHTML
			else if ( dom.outerHTML ) {
				dataAttrs = constructDatasetByHTML( dom );
			}
			// 支持 DOM 的 attributes
			else if ( dom.attributes && _T.isNumeric(dom.attributes.length) ) {
				dataAttrs = constructDatasetByAttributes( dom );
			}
		}
		
		return dataAttrs;
	}
});

/**
 * 通过 HTML 构建 dataset
 * 
 * @method	constructDatasetByHTML
 * @param	{DOM} dom
 * @return	{JSON}
 */
function constructDatasetByHTML( dom ) {
	var dataAttrs = {};
	
	$.each( (dom.outerHTML.match( /(data(-[a-z]+)+=[^\s>]*)/ig ) || []), function( idx, attr ) {
		attr = attr.match( /data-(.*)="([^\s"]*)"/i );
		
		dataAttrs[ _T.camelCase(attr[1]) ] = attr[2];
	});
	
	return dataAttrs
}

/**
 * 通过属性列表构建 dataset
 * 
 * @method	constructDatasetByAttributes
 * @param	{DOM} dom
 * @return	{JSON}
 */
function constructDatasetByAttributes( dom ) {
	var dataAttrs = {};
	
	$.each( dom.attributes, function( idx, attr ) {
		var match;
		
		if ( attr.nodeType === 2 && (match = attr.nodeName.match( /^data-(.*)$/i )) ) {
			dataAttrs[ _T.camelCase(match[1]) ] = attr.nodeValue;
		}
	});
	
	return dataAttrs;
}

}
	
})( window );