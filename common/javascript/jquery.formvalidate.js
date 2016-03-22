/********************************************************************
 * Author:	Ourai
 * Website:	http://www.otakism.com/
 * Create:	2011.10.13
 * Version:	1.1
 *------------------------------------------------------------------
 * This is a jQuery plugin of validating form elements,
 * which is coded based on jQuery 1.6.1 version.
 *
 * Users could customize rules of validating.
 *------------------------------------------------------------------
 * Parameters:	validate = {
 *								title:		elementName,	specify a symbol of validated element
 *								rule:		ruleName,		specify a rule for validated element
 *								[required:	1/0],			whether the element could be set null
 *								[min:		minScope],		specify the scope of element's value
 *								[max:		maxScope]		specify the scope of element's value
 *						}
 *						
 * Example:		<input type="text" validate="{title: 'E-mail', rule: 'email', required: 1, min: 3, max: 40}" value="ourairyu@hotmail.com" />
 ********************************************************************/
(function($) {
	var _errors = {
		init: "初始化错误！",
		null: "不能为空！",
		format: "格式不正确！"
	};
	
	var _private = {
		symbol: "validator",
		errors: {
			init: "初始化错误！",
			null: "不能为空！",
			format: "格式不正确！",
			length: "内容长度不符合要求！"
		},
		rules: {
			required: [/.+/, _errors.null],
			birthday: [/^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/, _errors.format]
		},
		result: [],
		validateInput: function(element, rules) {
			switch(element.type) {
				case "text":
					break;
				case "file":
					break;
				case "checkbox":
					break;
				case "radio":
					break;
			}
			
			var _result = new Array();
			for (var r in rules) {
				var _currentRule = r == "rule" ? rules[r] : r;
				var _tooltip = "该项";
				
				if (_currentRule == "title") {
					_tooltip = $.trim(rules[r]) == "" ? _tooltip : $.trim(rules[r]);
					break;
				}
				
				switch(typeof(_private.rules[_currentRule][0])) {
					case "object":
						_result.push([_private.rules[_currentRule][0].test($(element).val()), _currentRule]);
						break;
					case "function":
						break;
				}
			}

			for (var i=0, j=_result.length; i<j; i++) {
				if (_result[i][0]) {
					_private.result[_private.result.length] = [1, element, "OK"];
				}
				else {
					_private.result[_private.result.length] = [0, element, _tooltip + _private.rules[_result[i][1]][1]];
					break;
				}
			}
		},
		validateSelect: function(element, rules) {
			for (var r in rules) {
				var _result = 0;
							
				if (_private.rules[rules[r]][0].test($(element).val())) {
					_result = 1;
				}
					
				_private.result.push([_result, element]);
			}
		},
		validateTextarea: function(element, rules) {
			for (var r in rules) {
				var _result = 0;
							
				if (_private.rules[rules[r]][0].test($(element).val())) {
					_result = 1;
				}
					
				_private.result.push([_result, element]);
			}
		},
		callback: function(result) {
			for (var i in result) {
				document.write("result" + i + 1 + ": ");
				for (var j in result[i]) {
					document.write(result[i][j] + " ");
				}
				document.write("<br />");
			}
		},
		validate: function(form, callback) {
			var _form = $(form);
			var _elements = _form.find("[" + _private.symbol + "]");
						
			_elements.each(function() {
				var _type = this.tagName.toLowerCase();
				if (_type == "input" || _type == "select" || _type == "textarea") {
					var _expression = $(this).attr(_private.symbol);
					var _flag = this.id || this.name || this.className || "";
					
					if (/\{(\s*[a-z]+:\s*[\'\"]?[\S]+[\'\"]?\,\s*)*\s*[a-z]+:\s*[\'\"]?[\S]+[\'\"]?\}/.test(_expression)) {
						try {
							var _json = eval("json=" + _expression);
							
							switch(_type) {
								case "input":
									_private.validateInput(this, _json);
									break;
								case "select":
									_private.validateSelect(this, _json);
									break;
								case "textarea":
									_private.validateTextarea(this, _json);
									break;
							}
						}
						catch(e) {
							alert("验证项 " + _flag + " 的 " + _private.symbol + " 存在语法错误！");
							return false;
						}
					}
					else {
						alert("验证项 " + _flag + " 的 " + _private.symbol + " 存在语法错误！");
						return false;
					}
				}
			});
			
			callback(_private.result);
		}
	}
	
	$.extend({
		formValidate: {
			getRules: function(rules) {
				// 获取指定规则的正则表达式：获取全部留空，获取一个填入字符串，获取多个填入数组
			},
			setRules: function(rules) {
				// 重置或添加规则
				if (typeof(rules) === "object") {
					$.extend(_default.rules, rules);
				}
				else {
					alert("请检查规则设置是否正确！");
				}
			},
			result: function() {
				return _private.getResult();
			}
		}
	});
	
	$.fn.extend({
		formValidate: function(callback) {
			var _object = this;
			
			if (_object.get(0).nodeType !== 1 || _object.get(0).nodeName.toLowerCase() !== "form" || _object.html() === "") {
				return false;
			}
			
			_object.bind({
				validate: function() {
					if (callback && typeof(callback) === "function") {
						_private.validate(this, callback);
					}
					else {
						_private.validate(this, _private.callback);
					}
				},
				submit: function() {
					$(this).trigger("validate");
					
					if ($.formValidate.result != 1) {
						return false;
					}
				}
			});
		}
	})
})(jQuery);