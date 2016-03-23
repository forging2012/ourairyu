/*
 * jQuery Extend-Modules List @VERSION
 *
 * @Author:		Ourai Lin
 * @Data:		Dec 1st, 2011
 *
 * http://labs.otakism.com/
 *
 * Depends:
 *	jquery.ex.core.js
 *	jquery.ex.module.js
 */
(function( $ ) {

var exListClasses = {
	rowOdd: "ex-list-row-odd",
	rowEven: "ex-list-row-even",
	leftEdge: "ex-list-edge-left",
	rightEdge: "ex-list-edge-right"
};

$.module( "ex.list", {
	options: {
		"viewMode": "detail",								// detail, tile, thumbnail
		"textMode": "part",									// part, full
		"columns": [],
		"count": 10,
		"visiblePageNum": 5,
		"checkbox": {
			"show": true,
			"visible": false
		},
		"autoPage": true,
		"columnResizable": false,
		"showSelectAll": false,
		
		"firstPageText": "首页",
		"lastPageText": "末页",
		"prevPageText": "上一页",
		"nextPageText": "下一页",
		"selectPageText": "选择本页",
		"selectAllText": "选择全部",
			
		"selectedItems": null
	},
	
	reload: function() {
		this._getSelectedItems();
		return this._create();
	},
	
	_create: function() {
		this._checkForm();
		
		if ( this.options.jsonData ) {
			this._constructList( this.options.jsonData );
		}
		else {
			var module = this,
				list = this.element,
				ajaxParams = this._getAjax();
					
			// Get data of list via ajax
			if ( ajaxParams ) {
				$.ajax({
					url: ajaxParams[ "url" ],
					type: ajaxParams[ "type" ],
					data: ajaxParams[ "data" ],
					dataType: ajaxParams[ "dataType" ] || "json",
					cache: false,
					success: function( data ) {
						if ( list.closest( "." + module.moduleBaseClass + "-form" ).size() ) {
							for ( var i = 0, formData = list.closest( "." + module.moduleBaseClass + "-form" ).serializeArray(); i < formData.length; i++ ) {
								data[ formData[ i ][ "name" ] ] = formData[ i ][ "value" ];
							}
						}
							
//						if ( data[ "code" ] > 0 ) {
							module._constructList( data );
//						}
//						else {
//							list.find( "tbody" ).empty();
//						}
					}
				});
			}
		}
		
		return this.element;
	},
	
	_init: function() {
		if ( this.options.viewMode === "detail" ) {
			var module = this,
				self = this.element,
				
				colResizable = false,
				colFocused = false,
				targetCol = undefined,
				maxSize = undefined,
				
				rowSelectedClass = this.moduleBaseClass + "-row-selected";
			
			if ( module.options.columnResizable === true ) {
				$( "thead th", self ).live({
					"mousemove": function( e ) {
						var mPosX = Math.floor( ($( this ).offset().left + $( this ).outerWidth()) );
						
						if ( e.pageX > mPosX - 3 && e.pageX < mPosX + 3 && ($( "thead th", self ).index( $( this ) ) !== $( "thead th", self ).size() - 1) ) {
							self.addClass( module.moduleBaseClass + "-colresize" );
							colResizable = true;
							targetCol = $( this );
						}
						else {
							if ( colResizable && !colFocused ) {
								self.removeClass( module.moduleBaseClass + "-colresize" );
								colResizable = false;
							}
						}
					},
					"mousedown": function( e ) {
						if ( e.target === this ) {
							if ( !maxSize ) {
								maxSize = self.outerWidth();
							}
							colFocused = true;
						}
						$("#log").html( String(colResizable)+", "+String(colFocused)+", "+(targetCol) );
					}
				});
				
				self.bind({
					"mouseup": function( e ) {
						colFocused = colResizable = false;
						targetCol = undefined;
						self.removeClass( module.moduleBaseClass + "-colresize" );
					},
					"mouseout": function( e ) {
						if ( e.pageY >= (self.offset().top + self.outerHeight()) || e.pageX <= self.offset().left || e.pageY <= self.offset().top || e.pageX >= (self.offset().left + self.outerWidth()) ) {
							colFocused = colResizable = false;
							targetCol = undefined;
							self.removeClass( module.moduleBaseClass + "-colresize" );
						}
					},
					"mousemove": function( e ) {
						$("#log").html(maxSize+", "+self.width());
						if ( colResizable && colFocused && targetCol ) {
							$( "col:eq(" + $( "thead th", self ).index( targetCol ) + ")", self ).width(function( i, w ) {
								if ( self.outerWidth() <= maxSize ) {
									return (e.pageX - targetCol.offset().left);
								}
							});
						}
					}
				});
			}
			
			if ( this.options.checkbox.show === true ) {
				$( "thead :checkbox:first", self ).live( "click", function() {
					var listRows = $( "tbody tr", self );
					$( "tbody :checkbox", self ).attr( "checked", ($(this).attr( "checked" ) || false) );
					$(this).attr( "checked" ) ? listRows.addClass( rowSelectedClass ) : listRows.removeClass( rowSelectedClass );
				});
				
				$( "tbody tr", self ).live( "click", function( e ) {
					var target = e.target.nodeName.toLowerCase();
					
					if ( target === "tr" || target === "td" || target === "th" || target === "input" ) {
						$( this ).hasClass( rowSelectedClass ) ? $( this ).removeClass( rowSelectedClass ) : $( this ).addClass( rowSelectedClass );
						$( this ).find( "th :checkbox" ).attr( "checked", $( this ).hasClass( rowSelectedClass ) );
						$( "thead :checkbox:first", self ).attr( "checked", ($( "tbody :checked", self ).size() === $( "tbody :checkbox", self ).size()) );
					}
					
					e.stopPropagation();
				});
			}
		}
	},
	
	_checkForm: function() {
		var list = this.element,
			form = list.closest( "form" );
		
		if ( !form.hasClass( this.moduleBaseClass + "-form" ) ) {
			form.addClass( this.moduleBaseClass + "-form" );
		}
		
		if ( !$( "[name='currentpage']", form ).size() ) {
			form.append( "<input type=\"hidden\" name=\"currentpage\" value=\"1\" />" );
		}
		
		if ( !$( "[name='limit']", form ).size() ) {
			form.append( "<input type=\"hidden\" name=\"limit\" value=\"" + this.options.count + "\" />" );
		}
		
		if ( parseInt( $( "[name='limit']", form ).val(), 10 ) !== list.data( "originalLimit" ) ) {
//			$( "[name='currentpage']", self.closest( "form" ) ).val( "1" );
		}
	},
	
	_constructList: function( listData ) {
		if ( this.options.viewMode === "detail" ) {
			this._constructDetailList( listData );
			
			// Construct the pagination for list
			if ( this.options.autoPage === true ) {
				this._constructPage( listData[ "total" ] || listData[ "items" ].length );
			}
		}
		else if ( this.options.viewMode === "tile" ) {
			this._constructTileList( listData );
		}
		
		this._trigger( "create", "", listData );
	},
	
	_constructDetailList: function( listData ) {
		var module = this,
			self = module.element,
			options = module.options,
			
			sbCol = new Array(),
			sbThead = new Array(),
			sbTbody = new Array(),
			
			listHeaderInited = false,
			listItems = listData.items;
		
		if ( options.columns.length ) {
			sbCol.push( "<colgroup>" );
			sbThead.push( "<thead><tr>" );
			sbTbody.push( "<tbody>" );
			
			if ( options.jsonData ) {
				var currentPageNum = $( "[name='currentpage']", self.closest( "." + module.moduleBaseClass + "-form" ) ).val(),
					itemsNum = parseInt( $( "[name='limit']", self.closest( "." + module.moduleBaseClass + "-form" ) ).val(), 10 );
				
				listItems = listData.items.slice( (currentPageNum-1)*itemsNum, (currentPageNum*itemsNum > listData.items.length ? listData.items.length : currentPageNum*itemsNum) );
			}
			
			$.each( listItems, function( index, item ) {
				if ( index !== 0 ) {
					listHeaderInited = true;
				}
				
				sbTbody.push( "<tr>" );
				
				$.each( options.columns, function( i, col ) {
					if ( !listHeaderInited ) {
						sbCol.push( "<col style=\"" + ( isNaN( Number( col[ "width" ] ) ) ? "" : ( "width: " + Number( col[ "width" ] ) + "px;" ) ) + "\" />" );
					}
					
					if ( options.checkbox.show === true && i === 0 ) {
						if ( !listHeaderInited ) {
							if ( options.checkbox.visible === true ) {
								sbThead.push( "<th style=\"text-align: center !important;\">" );
							}
							else {
								sbThead.push( "<th>" );
							}
							
							sbThead.push( "<input type=\"checkbox\" value=\"\" title=\"" + (options.autoPage === true ? options.selectPageText : options.selectAllText) + "\" /></th>" );
						}
						
						sbTbody.push( "<th><input type=\"checkbox\" value=\"" + item[ col.key ] + "\" /></th>" );
					}
					else {
						if ( !listHeaderInited ) {
							sbThead.push( "<th>" + ( col.title || "" ) + "</th>" );
						}
						
						if ( options.viewMode === "detail" && options.textMode === "part" ) {
							sbTbody.push( "<td title=\"" + ( col.tooltip || module._transformSpecialChar( item[ col.key ] ) ) + "\">" );
						}
						else {
							sbTbody.push( "<td>" );
						}
						
						sbTbody.push( module._transformSpecialChar( item[ col.key ] ) + "</td>" );
					}
				});
				
				sbTbody.push( "</tr>" );
			});
			
			sbCol.push( "</colgroup>" );
			sbThead.push( "</tr></thead>" );
			sbTbody.push( "</tbody>" );
		}
		
		self.empty().append( sbCol.join("") + sbThead.join("") + sbTbody.join("") );
		
		if ( options.checkbox.show === true && options.checkbox.visible === false ) {
			$( ":checkbox", self ).parent().hide();
			$( "col:first", self ).remove();
		}
		
		if ( $( "tr:first", self ).children().eq( 0 ).css( "display" ) === "none" ) {
			$( "tr", self ).each(function() {
				module._preposeNewClass.call( $( this ).children().eq( 1 ), exListClasses.leftEdge );
			});
		}
		else {
			module._preposeNewClass.call( $( "tr th:first-child, tr td:first-child", self ), exListClasses.leftEdge );
		}
		
		if ( !self.hasClass( module.moduleBaseClass ) ) {
			module._preposeNewClass.call( self, module.moduleBaseClass );
		}
		if ( options.viewMode === "detail" && options.textMode === "part" ) {
			self.addClass( module.moduleBaseClass + "-texthide" );
		}
		else {
			self.removeClass( module.moduleBaseClass + "-texthide" );
		}
		module._preposeNewClass.call( $( "tr th:last-child, tr td:last-child", self ), exListClasses.rightEdge );
		module._preposeNewClass.call( $( "tbody tr:even", self ), exListClasses.rowEven );
		module._preposeNewClass.call( $( "tbody tr:odd", self ), exListClasses.rowOdd );
		$( "tbody tr:last", self ).addClass( "last" );
		
		module._initSelectedRows();
	},
	
	_constructTileList: function( listData ) {
		var self = this.element,
			options = this.options,
			sbItem = new Array();
		
		$.each( listData.items, function( index, item ) {
			sbItem.push( "<li>" );
			
			$.each( options.columns, function( i, col ) {
				
			});
			
			sbItem.push( "</li>" );
		});
	},
	
	_constructPage: function( itemTotal ) {
		var module = this,
			form = this.element.closest( "form" ),
			itemTotal = Number( itemTotal );
			
		if ( itemTotal ) {
			$( "." + module.moduleBaseClass + "-meta", form ).remove();
			this.element.after( "<table class=\"" + module.moduleBaseClass + "-meta\"><tbody><tr><th /></tr></tbody></table>" );
			if ( module.options.viewMode === "detail" && module.options.checkbox.show === true && module.options.showSelectAll === true ) {
				$( "." + module.moduleBaseClass + "-meta", form ).prepend( "<colgroup><col /></colgroup>" );
				$( "." + module.moduleBaseClass + "-meta col:first", form ).width( module.options.columns[ 0 ].width );
				$( "." + module.moduleBaseClass + "-meta tbody tr:first th", form )
					.append( "<input type=\"checkbox\" value=\"all\" title=\"" + module.options.selectAllText + "\" />" )
					.find( ":checkbox" )
					.bind( "change", function( e ) {
						$( "." + module.moduleBaseClass + " :checkbox", form ).attr( "disabled", ($(this).attr( "checked" ) || false) );
					});
			}
			$( "." + module.moduleBaseClass + "-meta tbody tr:first", form ).append( "<td><div class=\"" + module.moduleBaseClass + "-page\" /></td>" );
			this._createPagination( itemTotal );
		}
	},
	
	_createPagination: function( count ) {
		var module = this,
			form = module.element.closest( "form" ),
			pageWrapper = $( "." + module.moduleBaseClass + "-page", form ),
			
			itemNumPer = $( "[name='limit']", form ).size() ? parseInt( $( "[name='limit']", form ).val(), 10 ) : 10,
			pageTotal = Math.ceil( count/itemNumPer ),
			currentPageNum = parseInt( $( "[name='currentpage']", form ).val(), 10 ),
			visiblePageNum = parseInt( module.options.visiblePageNum, 10 ) > pageTotal ? pageTotal : parseInt( module.options.visiblePageNum, 10 ),
			apartPages = Math.floor( visiblePageNum/2 ),
			startPage = currentPageNum - apartPages <= 1 ? 1 : pageTotal - currentPageNum <= apartPages ? pageTotal - 2*apartPages : currentPageNum - apartPages,
			
			stringBuffer = new Array();
		
		for ( var i = startPage, j = pageTotal <= apartPages + currentPageNum ? pageTotal : currentPageNum <= apartPages ? visiblePageNum : currentPageNum + apartPages; i <= j; i++ ) {
			if ( i === currentPageNum ) {
				stringBuffer.push( "<span class=\"" + module.moduleBaseClass + "-page-number\" x-temp-data=\"" + i + "\">" + i + "</span>" );
			}
			else {
				stringBuffer.push( "<a href=\"javascript:void(0);\" class=\"" + module.moduleBaseClass + "-page-number\" x-temp-data=\"" + i + "\">" + i + "</a>" );
			}
		}
		
		if ( currentPageNum !== 1 ) {
			stringBuffer.splice( 0, 0, "<a href=\"javascript:void(0);\" class=\"" + module.moduleBaseClass + "-page-number " + module.moduleBaseClass + "-page-prev\" x-temp-data=\"" + (currentPageNum - 1) + "\" title=\"" + module.options.prevPageText + "\">" + module.options.prevPageText + "</a>" );
		}
		if ( currentPageNum > apartPages + 1 ) {
			stringBuffer.splice( 0, 0, "<a href=\"javascript:void(0);\" class=\"" + module.moduleBaseClass + "-page-number " + module.moduleBaseClass + "-page-first\" x-temp-data=\"1\" title=\"" + module.options.firstPageText + "\">" + module.options.firstPageText + "</a>" );
			stringBuffer.splice( 2, 0, "<span>...</span>" );
		}
		stringBuffer.splice( 0, 0, "<span class=\"" + module.moduleBaseClass + "-page-total\">共" + count + "条</span>" );
		stringBuffer.splice( 0, 0, "<span>" + ( itemNumPer*( currentPageNum-1 )+1 ) + " - " + ( itemNumPer*currentPageNum > count ? count : itemNumPer*currentPageNum ) + ",</span>" );
		if ( currentPageNum < pageTotal ) {
			stringBuffer.push( "<a href=\"javascript:void(0);\" class=\"" + module.moduleBaseClass + "-page-number " + module.moduleBaseClass + "-page-next\" x-temp-data=\"" + (currentPageNum + 1) + "\" title=\"" + module.options.nextPageText + "\">" + module.options.nextPageText + "</a>" );
		}
		if ( currentPageNum < pageTotal - apartPages ) {
			stringBuffer.push( "<a href=\"javascript:void(0);\" class=\"" + module.moduleBaseClass + "-page-number " + module.moduleBaseClass + "-page-last\" x-temp-data=\"" + pageTotal + "\" title=\"" + module.options.lastPageText + "\">" + module.options.lastPageText + "</a>" );
			stringBuffer.splice( stringBuffer.length - 2, 0, "<span>...</span>" );
		}
		
		pageWrapper.append( stringBuffer.join("") );
		
		// Store pages' number on the elements and remove the temporary attributes
		$( "." + module.moduleBaseClass + "-page-number", pageWrapper ).each(function() {
			$( this ).data( "pageNum", $( this ).attr( "x-temp-data" ) );
			$( this ).removeAttr( "x-temp-data" );
		});
		
		// Action of turning page
		$( "a", pageWrapper ).bind( "click", function() {
			$( "[name='currentpage']", form ).val( $( this ).data( "pageNum" ) );
			
			module._getSelectedItems();
			
			$( ":" + module.moduleBaseClass, form ).each(function() {
				$(this).list( "reload" );
			});
		});
	},
	
	_getSelectedItems: function() {
		if ( this.options.checkbox.show === true && this.options.checkbox.visible === true ) {
			var list = this.element,
				checkedItems = new Array(),
				originalData = list.data( "pageChecked" );
		
			$( "tbody :checked", list ).each(function() {
				checkedItems.push( $(this).val() );
			});

			if ( !originalData ) {
				list.data( "pageChecked", {} );
				originalData = list.data( "pageChecked" );
			}
			
			originalData[ "page-" + $( ("span." + this.moduleBaseClass + "-page-number"), list.closest( "." + this.moduleBaseClass + "-form" ) ).data( "pageNum" ) ] = checkedItems.join( "," );
			
			list.data( "pageChecked", originalData );
		}
	},
	
	_initSelectedRows: function() {
		var self = this.element;
		
		// Initialize items' statuses which were checked
		if ( self.data("pageChecked") ) {
			var currentPageNum = $( "[name='currentpage']", self.closest( "form" ) ).val(),
				checkedItems = self.data("pageChecked")[ "page-" + currentPageNum ];
			
			if ( checkedItems && checkedItems.length ) {
				checkedItems = checkedItems.split( "," );
				
				if ( checkedItems.length === $( "tbody :checkbox", self ).size() ) {
					$( "tbody tr", self ).trigger( "click" );
				}
				else {
					$.each( checkedItems, function( i, n ) {
						$( "tbody :checkbox[ value='" + n + "' ]" ).closest( "tr" ).trigger( "click" );
					});
				}
			}
			
			checkedItems = new Array();
			
			$.each( self.data("pageChecked"), function( i, n ) {
				if ( n.length ) {
					checkedItems = checkedItems.concat( n.split( "," ) );
				}
			});
			
			this.options.selectedItems = checkedItems.join( "," ).length ? checkedItems.join( "," ) : null;
		}
	},
	
	_getAjax: function() {
		var self = this.element,
			form = self.closest( "form" );
			
		if ( form.size() > 0 ) {
			return {
					url: form.attr( "action" ) || "",
					type: form.attr( "method" ) || "post",
					data: form.serialize()
				}
		}
		else {
			var json = self.attr( "x-target" );
			
			if ( json && $.parseJSON( json ) ) {
				return $.parseJSON( json );
			}
			else {
				return null;
			}
		}
	}
});

$.extend( $.ex.list, {
	version: "0.4.2"
});

})( jQuery );