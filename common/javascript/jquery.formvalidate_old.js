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
	var _result = false;
	var _rules = {
		"birthday": /^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/,
		"BWH": /^B[1-9]\d{1,2}-W[1-9]\d{1,2}-H[1-9]\d{1,2}$/
	};
	
	$.extend({
		formValidate: function() {
			$(document).ready(function() {
				init();
			});
		}
	});
	
	function init() {
		var _form = $("form[validate='true']");
		
		if (_form.size() > 0) {
			_form.bind({
				formValidate: function() {
					validateForm($(this), _rules);
				},
				submit: function() {
					$(this).trigger("formValidate");
				}
			});
		}
		else {
			alert("没有发现需要验证的表单！");
		}
	}
	
	function validateForm(form, rules) {
		var _inputs = form.find("input[validate]");
		
		_inputs.each(function() {
			var _expression = $(this).attr("validate");
			var _value = $(this).val();
			alert(typeof(eval("json="+_expression)));
			if (/\{(\s*[a-z]+:\s*[\'\"]?[\S]+[\'\"]?\,\s*)*\s*[a-z]+:\s*[\'\"]?[\S]+[\'\"]?\}/.test(_expression)) {
				try {
					var _json = eval("json=" + _expression);
					
					if (_json["title"] && $.trim(_json["title"]) !== "") {
						if (_json["required"]) {
							if (_json["required"] == 1) {
								if ($.trim(_value) === "") {
									alert(_json["title"] + "的值不能为空！");
									$(this).focus();
									return false;
								}
							}
							else {
								alert(_json["title"] + "的\"validate\"属性中的\"required\"设置不正确！");
								$(this).focus();
								return false;
							}
						}
														
						if (_json["min"] && _value !== "") {
							if (!isNaN(Number(_json["min"]))) {
								if (isNaN(Number(_value))) {
									alert(_json["title"] + "的值类型错误！");
									$(this).focus();
									return false;
								}
								else {
									if (Number(_value) < Number(_json["min"])) {
										alert(_json["title"] + "的值小于该元素指定的最小值！");
										$(this).focus();
										return false;
									}
								}
							}
							else {
								alert(_json["title"] + "的\"validate\"属性中的\"min\"设置不正确！");
								$(this).focus();
								return false;
							}
						}
							
						if (_json["max"] && _value !== "") {
							if (!isNaN(Number(_json["max"]))) {
								if (isNaN(Number(_value))) {
									alert(_json["title"] + "的值类型错误！");
									$(this).focus();
									return false;
								}
								else {
									if (Number(_value) > Number(_json["max"])) {
										alert(_json["title"] + "的值大于该元素指定的最大值！");
										$(this).focus();
										return false;
									}
								}
							}
							else {
								alert(_json["title"] + "的\"validate\"属性中的\"max\"设置不正确！");
								$(this).focus();
								return false;
							}
						}

						if (_json["rule"] && _value !== "") {
							if (typeof(_json["rule"]) === "string" && $.trim(_json["rule"]) !== "") {
								if (rules && typeof(rules) === "object" && $.makeArray(rules).length > 0) {
									if (rules[_json["rule"]]) {
										if (!rules[_json["rule"]].test(_value)) {
											alert(_json["title"] + "的格式不正确！");
											$(this).focus();
											return false;
										}
									}
									else {
										alert("规则池中不存在" + _json["title"] + "所指定的规则，请添加后再进行验证！");
										$(this).focus();
										return false;
									}
								}
								else {
									alert("表单验证规则池出现异常，请仔细检查！");
									$(this).focus();
									return false;
								}
							}
							else {
								alert(_json["title"] + "的\"validate\"属性中的\"rule\"未定义或者设置不正确！");
								$(this).focus();
								return false;
							}
						}
					}
					else {
						throw "被验证元素的\"validate\"属性中的\"title\"未定义或者设置不正确！";
					}
				}
				catch(e) {
					if (typeof(e) === "object") {
						alert("请检查被验证元素的\"validate\"属性是否设置正确！");
						$(this).focus();
						return false;
					}
					else {
						alert(e);
						$(this).focus();
						return false;
					}
				}
			}
			else {
				alert("请检查被验证元素的\"validate\"属性是否设置正确！");
				$(this).focus();
				return false;
			}
		});
	}
	
	$.formValidate();
})(jQuery);