(function($) {
	var regExpGroup = {
		"json": /^\{(\s*[\"\']?[a-z]+[\"\']?:\s*[\"\']?.+[\"\']?\,)*(\s*[\"\']?[a-z]+[\"\']?:\s*[\"\']?.+[\"\']?)\}$/,
		"url": /^(http|https|ftp):\/\/([\w_-]+\.)+[a-z]{1,5}(\/(\w+\/)*(\w+\.[a-z]{1,5}(\?\w+=\w+(\&\w+=\S+)*)?)?)?$/,
		"protocol": /^([a-z]+:)\S+$/,
		"pathname": /^[a-z]+:\/\/([\w_-]+\.)+[a-z]{1,5}(\/\S+.[a-z]{1,5})?\?\S*$/
	}
	
	$.extend({
		parseJSONex: function(jsonString, isLoose) {
			if (isLoose === undefined || typeof(isLoose) === "boolean") {
				if (!isLoose) {
					if (typeof(jsonString) !== "string" || !regExpGroup["json"].test(jsonString)) {
						return null;
					}
					
					try {
						return eval("json=" + jsonString);
					}
					catch(e) {
						return null;
					}
				}
				else {
					return $.parseJSON(jsonString);
				}
			}
			else {
				return null;
			}
		},
		parseURLex: function(urlString) {
			if (typeof(urlString) === "string" && regExpGroup["url"].test(urlString)) {
				return {
					url: urlString,
					protocol: urlString.match(regExpGroup["protocol"])[1],
					pathname: urlString.match(regExpGroup["pathname"]) == null ? null : urlString.match(regExpGroup["pathname"])[2]
				}
			}
			else {
				return null;
			}
		}
	});
})(jQuery);