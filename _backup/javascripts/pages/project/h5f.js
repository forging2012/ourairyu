(function(){$(document).ready(function(){var a,b,c;return c=$("#H5FValidation form"),H5F.errors({UNKNOWN_INPUT_TYPE:"{{LABEL}}字段为未知类型",COULD_NOT_BE_EMPTY:"{{LABEL}}的值不能为空",LENGTH_SMALLER_THAN_MINIMUM:"{{LABEL}}的字符串长度请保持在在 {{MINLENGTH}}-{{MAXLENGTH}}",LENGTH_BIGGER_THAN_MAXIMUM:"{{LABEL}}的字符串长度请保持在在 {{MINLENGTH}}-{{MAXLENGTH}}",INVALID_VALUE:"{{LABEL}}的值{{VALUE}}为无效值",NOT_AN_ABSOLUTE_URL:"{{LABEL}}不符合 URL 的格式",NOT_AN_EMAIL:"{{LABEL}}不符合电子邮箱的格式",NOT_A_NUMBER:"{{LABEL}}不是数字",UNDERFLOW:"{{LABEL}}中所输入数字请在 {{MIN}}-{{MAX}} 范围内",OVERFLOW:"{{LABEL}}中所输入数字请在 {{MIN}}-{{MAX}} 范围内",DIFFERENT_VALUE:"{{LABEL}}的值没有与{{ASSOCIATE_LABEL}}保持一致",AT_LEAST_CHOOSE_ONE:"请从{{LABEL}}中选择一项",SHOOLD_BE_CHOSEN:"请选中{{UNIT_LABEL}}",SHOOLD_CHOOSE_AN_OPTION:"必须从{{LABEL}}中选择一项"}),H5F.init(c,{immediate:!0}),$("#H5FValidation [name]").on({"H5F:valid":function(a,b){return $(b.element).closest(".form-group").removeClass("has-error").children(".help-block").hide()},"H5F:invalid":function(a,b){var c;return c=$(b.element).closest(".form-group"),0===$(".help-block",c).size()&&c.append('<p class="help-block" />'),c.addClass("has-error").children(".help-block").show().text(b.message)}}),c.on("H5F:submit",function(a,b,c){return console.log("submit"),!1}),a=$("#exampleForm_2"),a.on("H5F:submit",function(){return console.log("exampleForm_2 submit"),"exampleForm_2"}),b=H5F.get(a),b.addValidation("nickname",{handler:function(){return!isNaN(Number(this.value))},message:"请输入数字"}),b.addValidation("nickname",{handler:function(){return this.value.length>5},message:function(){return"请保证字符串长度大于 5"}}),$("#exampleForm_3").on("H5F:submit",function(){return console.log("exampleForm_3 submit"),"exampleForm_3"})})}).call(this);