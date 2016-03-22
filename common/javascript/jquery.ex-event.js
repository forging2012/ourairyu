(function($) {
	$.fn.extend({
		list: function(option, callback) {
			var _this = this;
			var _DOM = _this.get(0);
			
			if (checkNodeType.call(_DOM, "list")) {
				var _option = {
					"page": true
				};
				
				if (arguments.length === 0) {
					if (_this.data("callback")) {
						_this.trigger("list.ex");
					}
					else {
						return false;
					}
				}
				else {
					if (typeof(option) != "function" && !$.parseJSONex(option)) {
						return false;
					}
					else {
						var _nodetype = _DOM.nodeName.toLowerCase();
						var _callback = typeof(option) === "function" ? option : callback;
						
						if (_callback != option && $.parseJSONex(option)) {
							_option = $.extend({}, _option, $.parseJSONex(option));
						}
						
						if (_nodetype == "table") {
							var _matchArray = location.search.match(/[\?\&]limit=([0-9]{1,2})(\&\S+)?/);
							
							if (_matchArray && _matchArray.length >= 2 && Number(_matchArray[1])) {
								$("option[value='" + _matchArray[1] + "']", $("select[name='limit']")).attr("selected", true);
							}
							else {
								$("select[name='limit'] option:first").attr("selected", true);
							}
						}
		
						// 选择每页显示数据条数
						$("select[name='limit']").live("change", function() {
							$("[name='currentpage']", _this.closest("form[x-form='list']")).val("1");
							_this.trigger("list.ex");
						});
						
						_this.data("option", _option);
						_this.data("callback", _callback);
						_this.trigger("list.ex");
					}
				}
			}
			else {
				return false;
			}
		},
		/*listEx: function() {
			var _this = this;
			var _DOM = _this.get(0);
			
			if (_DOM.nodeType == 1 && _DOM.nodeName.toLowerCase() == "form" && _this.attr("x-form") && _this.attr("x-form") == "list") {
				alert(_DOM.nodeName);
			}
			else {
				return false;
			}
		},*/
		page: function(data, option) {
			var _this = this;
			var _DOM = _this.get(0);
			var _params = {
				"visiblepagenum": 5,
				"firstpage": "首页",
				"lastpage": "末页",
				"prevpage": "上一页",
				"nextpage": "下一页",
				"selectall": false
			};
			
			if (checkNodeType.call(_DOM, "page", "form")) {
				if (data["total"] > 0) {
					// 定义与页码相关变量
					var currPagination = parseInt(data["currentpage"], 10);
					var itemPerPage = parseInt(data["limit"], 10);
					var itemTotal = parseInt(data["total"], 10);
					var pageTotal = Math.ceil(itemTotal/itemPerPage);
					var pageHTML = new StringBuffer();
					
					if (typeof(option) === "object") {
						_params = $.extend({}, _params, option);
					}
					
					// 信息数及页数统计
					pageHTML.append("<div id=\"x-id-pagination\" class=\"clearfix\"><span>" + (itemPerPage*(currPagination-1)+1));
					pageHTML.append(" - ");
					if (itemPerPage*currPagination > itemTotal) {
						pageHTML.append(itemTotal);
					}
					else {
						pageHTML.append(itemPerPage*currPagination);
					}
					pageHTML.append(",</span><span id=\"x-id-total\">");
					pageHTML.append("共" + itemTotal + "条</span>");
					
					// 页码
					var startCount = 1;
					var pageNum = _params["visiblepagenum"];
					if (currPagination != 1) {
						if (pageTotal > pageNum) {
							if (currPagination > (pageNum-2)) {
								pageHTML.append("<a id=\"x-id-first\" href=\"javascript:void(0);\" x-page=\"1\" title=\"" + _params["firstpage"] + "\">" + _params["firstpage"] + "</a>");
							}
						}
						pageHTML.append("<a id=\"x-id-prev\" href=\"javascript:void(0);\" x-page=\"" + (currPagination-1) + "\" title=\"" + _params["prevpage"] + "\">" + _params["prevpage"] + "</a>")
						if (pageTotal > pageNum) {
							if (currPagination > (pageNum-2)) {
								pageHTML.append("<span>...</span>");
								startCount = (currPagination-2) <  (pageTotal-4) ? (currPagination-2) : (pageTotal-4);
							}
						}
					}
					for (var i=1; i<=pageTotal; i++) {
						if (i >= startCount && i < (startCount + pageNum)) {
							if (i == currPagination)
								pageHTML.append("<span class=\"current;\" x-page=\"" + i + "\">" + i + "</span>");
							else
								pageHTML.append("<a href=\"javascript:void(0);\" x-page=\"" + i + "\">" + i + "</a>");
						}
					}
					
					if (currPagination != pageTotal) {
						if (pageTotal > pageNum) {
							if (currPagination < (pageTotal-2)) {
								pageHTML.append("<span>...</span>");
							}
						}
						pageHTML.append("<a id=\"x-id-next\" href=\"javascript:void(0);\" x-page=\"" + (currPagination+1) + "\" title=\"" + _params["nextpage"] + "\">" + _params["nextpage"] + "</a>")
						if (pageTotal > pageNum) {
							if (currPagination < (pageTotal-2)) {
								pageHTML.append("<a id=\"x-id-last\" href=\"javascript:void(0);\" x-page=\"" + pageTotal + "\" title=\"" + _params["lastpage"] + "\">" + _params["lastpage"] + "</a>");
							}
						}
					}
					pageHTML.append("</div>");
						
					$("#x-id-pagination").remove();
					_this.append(pageHTML.toString());
					
					if ($("[x-act='list']", _this).size() == 1) {
						if ($("#x-id-meta").size() == 0) {
							if ($("[x-act='list']").get(0).tagName.toLowerCase() == "table") {
								_this.append(
									"<table id=\"x-id-meta\">" +
									"<colgroup><col style=\"width: 30px;\" /><col style=\"\" /><col style=\"\" /></colgroup>" +
									"<tbody><tr></tr></tbody></table>"
								);
							}
							else {
								_this.append("<div id=\"x-id-meta\" class=\"clearfix\"></div>");
							}
						}
						
						if ($("#x-id-all").size() == 0) {
							if ($("[x-act='list']").get(0).tagName.toLowerCase() == "table") {
								if (_params["selectall"]) {
									$("#x-id-meta tr").append("<th><input type=\"checkbox\" id=\"x-id-all\" value=\"all\" /></th><td><label for=\"x-id-all\">全选</label></td><td></td>");
								}
								else {
									$("#x-id-meta tr").append("<th></th><td></td><td></td>");
								}
								
								$("#x-id-meta td:last").append($("#x-id-pagination"));
							}
							else {
								$("#x-id-meta").append($("#x-id-pagination"));
							}
						}
					}
					
					$("[x-page]", $("#x-id-pagination")).bind("click", function() {
						$(this).trigger("page.ex");
						return false;
					});
				}
				else {
					$("#x-id-meta", _this).remove();
				}
				
				return $("#x-id-pagination");
			}
			else {
				return false;
			}
		},
		validate: function(rules, callback) {
			var _this = this;
			
			if (_this.size() > 0) {
				var _DOM = _this.get(0);
				
				if (_DOM.nodeType == 1 && _DOM.nodeName.toLowerCase() == "form" && $("[x-validator]", _this).size() > 0) {
					if (arguments.length === 1 && typeof(arguments[0]) === "function") {
						callback = arguments[0];
					}
					
					_this.live("submit", function() {
						if ($.parseJSONex(rules)) {
							_validateOptions.rules = $.extend({}, _validateOptions.rules, rules);
						}
						$(this).trigger("validate.ex");
						if (callback && typeof(callback) === "function") {
							callback.call(_DOM, _validateOptions.result);
						}
						
						//return _validateOptions.result;
						return false;
					});
				}
			}
		},
		roll: function() {
			var _this = this;
			
			if (checkNodeType.call(_this.get(0), "roll", "ul") || checkNodeType.call(_this.get(0), "roll", "ol")) {
				var _widthContainer = $("#scrollContainer").width();
				var _widthItem = _this.find("li:first").width();
				var _widthStep = _widthItem + parseInt(_this.find("li:first").css("margin-right"), 10);
				var _visibleCount = Math.floor(_widthContainer/_widthItem);
				var _seperatorIndex = Math.floor(_visibleCount/2);
				var _option = {
					"container": _this,
					"wrapperwidth": _widthContainer,
					"itemwidth": _widthItem,
					"step": _widthStep,
					"items": _visibleCount,
					"seperator": _seperatorIndex
				}

				_this.children("li").data("option", _option).bind("click", function() {
					$(this).trigger("roll.ex");
					return false;
				});
				
				$("#scrollPrev").live("click.ex", function() {
					if ($("#scrollContainer li").index($("#scrollContainer li.current")) > 0) {
						$("#scrollContainer li.current").prev().trigger("roll.ex");
					}
					
					return false;
				});
				
				$("#scrollNext").live("click.ex", function() {
					if ($("#scrollContainer li").index($("#scrollContainer li.current")) < $("#scrollContainer li").size() - 1) {
						$("#scrollContainer li.current").next().trigger("roll.ex");
					}
					
					return false;
				});
			}
			else {
				return false;
			}
		}
	});

	// 列表事件
	$("[x-act='list']").live("list.ex", function() {
		var _this = $(this);
		var _callback = _this.data("callback");
		var _option = _this.data("option");
		var ajaxParams = getAjax(_this);

		if (_callback && ajaxParams) {
			$.ajax({
				url: ajaxParams["url"],
				type: ajaxParams["type"],
				data: ajaxParams["data"],
				dataType: "json",
				success: function(data) {
					if (_this.closest("[x-form='list']").size() > 0) {
						var _ajaxParams = _this.closest("[x-form='list']").serializeArray();
						for (var i=0, j=_ajaxParams.length; i<j; i++) {
							data[_ajaxParams[i]["name"]] = _ajaxParams[i]["value"];
						}
					}

					_callback.call(_this.get(0), data);
					
					if (_option["page"]) {
						_this.closest("form[x-act='page']").page(data, _option);
					}
					
					return _this;
				}
			});
		}
		
		return false;
	});
	
	// 分页事件
	$("a[x-page]").live("page.ex", function() {
		var _this = $(this);
		var _form = _this.closest("form[x-form='list']");
		
		if (_form.size() > 0 && _form.attr("x-act") == "page") {
			$("input:hidden[name='currentpage']", _form).val(_this.attr("x-page"));
			$("table[x-act='list']", _form).trigger("list.ex");
		}
	});
	
	// 查询事件
	$("[x-query='submit']").live("query.ex", function() {
		var _this = $(this);
		var _form = _this.closest("form[x-act='query']");
		var _queryEleGroup = $("[x-query]:not([x-query='submit'])", _form);
		
		if (_form.size() > 0 && _queryEleGroup.size() > 0) {
			// 
		}
	});
	
	/*----------------------------------------------------------------
		验证事件

		<input type="text" x-validator="{'title':'电邮', 'required': 'true', 'rule': 'email', 'length': '12'}" />
	  ----------------------------------------------------------------*/
	var _errors = {
			init: "初始化错误！",
			"null": "不能为空！",
			format: "格式不正确！",
			length: "内容长度不符合要求！"
		};
		
	var _validateOptions = {
		result: false,
		rules: {
			"required": [/.+/, _errors["null"]],
			"url": [/^((http|https|ftp):\/\/((([\w_-]+\.)+[a-z]{1,5})|((\d{1,3}\.){3}\d{1,3}(:\d{4})?))(\/(\w+(\/)?)*(\w+\.[a-z]{1,5}(\?\w+=\w+(\&\w+=\S+)*)?)?)?)?$/, _errors.format],
			"email": [/^([\w\._-]+@([\w_-]+\.)+[a-z]{1,5})?$/, _errors.format],
			"ip": [/^((([01]?[\d]{1,2})|(2[0-4][\d])|(25[0-5]))(\.(([01]?[\d]{1,2})|(2[0-4][\d])|(25[0-5]))){3})?$/, _errors.format],
			"birthday": [/^([1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))?$/, _errors.format],
			"bwh": [/^([bB]\d{2,3}-[wW]\d{2,3}-[hH]\d{2,3})?$/, _errors.format],
			"length": [function(max) { return this.value.length <= max; }, _errors.length],
			"number": [/^\d*$/, _errors.format],
			"max": [],
			"min": []
		}
	}
	
	$("form").live("validate.ex", function() {
		var _validatedGroup = $("[x-validator]", $(this));
		var _results = new Array();
		var _flag = true;
		
		// 验证每个带有“x-validator”的元素
		_validatedGroup.each(function(index, element) {
			var _rule = $(this).attr("x-validator");
			
			if ($.parseJSONex(_rule)) {
				_flag = true;
				_rule = $.parseJSONex(_rule);
				var _result = validateEachRule(element, _rule);
				_results.push(_result);
			}
			else {
				alert("请检查第" + (index + 1) + "个被验证元素的验证规则语法是否正确！");
				_flag = false;
				_validateOptions.result = false;
				return false;
			}
			
		});
		
		if (_flag) {
			for (var i=0, j=_results.length; i<j; i++) {
				if (!_results[i]["result"]) {
					alert(_results[i]["msg"]);
					_validateOptions.result = false;
					return false;
				}
			}
			_validateOptions.result = true;
			return true;
		}
	});
	
	function validateEachRule(element, rule) {
		var _type = element.tagName.toLowerCase();
		
		if (_type == "input") {
			return validateInput(element, rule);
		}
		else if (_type == "select") {
			return validateSelect(element, rule);
		}
		else {
			return {
				result: false,
				msg: "不支持该被验证元素！"
			}
		}
	}
	
	function validateInput(element, rule) {
		var _this = $(element);
		var _type = _this.attr("type");
		
		if (_type == "text" || _type == "password") {
			var _title = rule["title"] || _this.attr("name") || "该元素";
			delete rule["title"];
			
			if (rule["required"] && (rule["required"] == "true" || rule["required"] == "1")) {
				if (_validateOptions["rules"]["required"][0].test(_this.val())) {
					delete rule["required"];
				}
				else {
					return {
						result: false,
						msg: _title + _validateOptions["rules"]["required"][1]
					}
				}
			}
			
			for (var i in rule) {
				var _validator = i == "rule" ? _validateOptions["rules"][rule[i]] : _validateOptions["rules"][i];
				var _result = false;
				
				if (typeof(_validator[0]) === "function") {
					_result = _validator[0].call(element, (rule[i])*1);
				}
				else {
					_result = _validator[0].test(_this.val());
				}
				
				if (!_result) {
					return {
						result: false,
						msg: _title + _validator[1]
					}
				}
			}
			
			return {
				result: true,
				msg: "OK"
			}
		}
	}
	
	/*----------------------------------------------------------------
		新增事件

		<a href="javascript:void(0);" x-btn="add" x-target="{'id': 'dialog', 'title': '对话框'}">新增</a>
		<div id="dialog">弹出对话框</div>
	  ----------------------------------------------------------------*/
	$("[x-act='add']").live("add.ex", function() {
		var _this = $(this);
		var _dialogParam = $.parseJSONex(_this.attr("x-target"));
		
		if (_dialogParam) {
			var _dialog = $("#" + _dialogParam["id"]);
			
			_dialog.dialog({
				title: _dialogParam["title"],
				minWidth: 600,
				/*dialogClass: "x-dlg",*/
				closeText: "关闭",
				modal: true,
				autoOpen: false,
				draggable: false,
				resizable: false,
				buttons: {
					"确定": function() {
						$(this).find("form").submit();
					}/*,
					"取消": function() {
						$(this).dialog("close");
					}*/
				}
			});
				
			_this.data("target", {"id": _dialogParam["id"], "title": _dialogParam["title"]});
			_this.removeAttr("x-target");
			
			return true;
		}
		else {
			alert("请检查 <" + _this.get(0).tagName + "> 的 x-target 属性是否设置正确！");
			return false;
		}
	});
	
	$("li").live("roll.ex", function(direction) {
		var _this = $(this);
		var _option = _this.data("option");

		if (_option && _option["step"] > 0) {
			var _primaryIndex = $("#scrollContainer li").index($("#scrollContainer li.current"));
			var _currentIndex = $("#scrollContainer li").index(_this);
			var _moveRange = 0;
			var _vector = _currentIndex < _primaryIndex ?  -((_option["items"] + 1) * _option["step"] - _option["wrapperwidth"]) : 0;
			
			if (_currentIndex <= _option["seperator"] - 1) {
				_moveRange = 0;
			}
			else if (_currentIndex > _option["seperator"] - 1 && _currentIndex < $("#scrollContainer li").size() - _option["seperator"] - 1) {
				_moveRange = -(_currentIndex - _option["seperator"]) * _option["step"] + _vector;
			}
			else {
				_moveRange = -($("#scrollContainer li").size() - _option["seperator"]*2 - 1) * _option["step"] - ((_option["items"] + 1) * _option["step"] - _option["wrapperwidth"]);
			}
			
			//_option["container"].css("margin-left", _moveRange + "px");
			_option["container"].animate({marginLeft: _moveRange}, "fast");
			$("#scrollContainer li.current").removeClass("current");
			_this.addClass("current");
		}
	});

	// 选择全部
	$("#x-id-all").live("click", function() {
		var _this = $(this);
		if (_this.attr("checked")) {
			$("table[x-act='list'] :checkbox").attr("disabled", true);
		}
		else {
			$("table[x-act='list'] :checkbox").attr("disabled", false);
		}
	});

	// 获取Ajax所需的参数
	function getAjax(jQueryObject) {
		var _this = jQueryObject;
		
		if (_this.closest("[x-form='list']").size() > 0) {
			_this = _this.closest("[x-form='list']");
			
			return {
				url: _this.attr("action"),
				type: _this.attr("method") || "post",
				data: _this.serialize()
			}
		}
		else if (_this.attr("x-target") && $.parseJSONex(_this.attr("x-target"))) {
			var _ajaxParams = $.parseJSONex(_this.attr("x-target"));
			_this.removeAttr("x-target");
			
			return {
				url: _ajaxParams["url"],
				type: _ajaxParams["type"] || "post",
				data: _ajaxParams["data"] || ""
			}
		}
		else {
			return null;
		}
	}
	
	// 异常处理
	function errorHandle(error) {
		if (typeof(error) == "object") {
			if ($.browser.msie) {
				alert("第 " + error["number"] + " 行发生错误: " + error["description"]);
			}
			else {
				alert("文件 " + error["fileName"] + " 第 " + error["lineNumber"] + " 行发生错误！ ");
			}
		}
		else {
			alert(error);
		}
	}
	
	/*----------------------------------------------------------------
		检查节点
	
		用 checkNodeType.call(this, exEvent, tagName) 的形式调用，所传参数为HTML元素的x-act属性值和元素的标签，this指向该HTML元素的DOM。
	  ----------------------------------------------------------------*/
	function checkNodeType(ex, tagname) {
		if (tagname && typeof(tagname) === "string") {
			return (this.nodeType === 1 && this.getAttribute("x-act") === ex && this.nodeName === tagname.toUpperCase());
		}
		else {
			return (this.nodeType === 1 && this.getAttribute("x-act") === ex);
		}
	}
	
	$(document).ready(function() {
		if ($("[x-act='add']").trigger("add.ex")) {
			$("[x-act='add']").click(function() {
				$("#" + $(this).data("target")["id"]).dialog("open");
			});
		}
	});
})(jQuery);