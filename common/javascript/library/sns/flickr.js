/**
 * JavaScript library to play with flickr API based on jQuery
 * 
 * This library is based on JavaScript 1.5(ECMA-262 3rd edition) and jQuery 1.7.1
 * API is provided by flickr
 * 
 * @author		Ourai Lin <ourairyu@hotmail.com>
 * @copyright	Otakism Promotion Association 2012
 * @package		library
 * @version		1.0
 * @category	JavaScript Library
 */
(function() {
	
if ( !window.jQuery ) {
	alert( "You haven't included jQuery JavaScript library before this file!\n\nplease put jQuery file in the correct position,\nor access jQuery's official website(http://jquery.com/) to download it.\n\nThanks for your support and have a good time!" );
	return false;
}

var win = window,
	$ = window.jQuery,
	
	FP = new Object(),	// FP is short for Flickr Private
	Flickr = function() {};
	
window["jsonFlickrApi"] = function( rsp ) {
	alert(rsp.stat);
};

$.extend( FP, {
	user: {
		id: "55640473@N05",
		username: "欧雷"
	},
	
	// list of flickr API method
	api: {
		contacts: {
			getList: "flickr.contacts.getList"
		},
		photos: {
			getInfo: "flickr.photos.getInfo",
			getExif: "flickr.photos.getExif",
			getSizes: "flickr.photos.getSizes"
		},
		photosets: {
			getInfo: "flickr.photosets.getInfo",
			getList: "flickr.photosets.getList",
			getPhotos: "flickr.photosets.getPhotos"
		},
		urls: {
			lookupUser: "flickr.urls.lookupUser"
		}
	},
	
	// a general method to get data from flickr
	get: function( params, keyword, callback ) {
		if ( !$.isPlainObject(params) || !params.method ) {
			alert( "Please specify a method of flickr API!" );
			return false;
		}
		
		var options = { "api_key": "baced9477f83d19e69b677b7cf4d7580", "format": "json", "nojsoncallback": 1 },
			encoded_opts = new Array();
		
//		if ( $.browser.msie ) {
//			$.ajaxSetup({ jsonpCallback: "jsonFlickrApi" });
//		}
//		else {
//			options["nojsoncallback"] = 1;
//		}
//		
		$.extend( options, params );
		$.each( options, function( key, value ) { encoded_opts.push( encodeURI(key) + "=" + encodeURI(value) ); });
		
		$.ajax({
			url: "http://api.flickr.com/services/rest/",
			type: "get",
			data: encoded_opts.join("&"),
			dataType: "json",
//			jsonpCallback: "jsonFlickrApi",
			crossDomain: true,
//			timeout: 3000,				// timeout when over 3 seconds
			success: function( data, textStatus ) {
				if ( data.stat == "ok" ) {
					if ( $.isFunction(callback) )
						callback.call(win, data[keyword]);
					else
						alert("\"" + callback + "\" is not a function!");
				}
				else
					alert(data.message);
			},
			error: function( xhr, status, error ) {
				alert( error );
			}
		});
	},
	
	getAllAlbum: function( callback ) {
		this.get({ method: this.api.photosets.getList, user_id: this.user.id }, "photosets", callback);
	},
	getAlbum: function( id, callback ) {
		this.get({ method: this.api.photosets.getInfo, photoset_id: id }, "photoset", callback);
	},
	getCover: function( album_id, callback ) {
		var _this = this, size = "q";
		this.get({ method: this.api.photosets.getPhotos, photoset_id: album_id, media: "photos", privacy_filter: 1 }, "photoset", function( photos ) {
			callback.call(win, _this.getPhotoUrl(photos.photo[0], size));
		});
	},
	getPhotoUrl: function( photo_info, size ) {
		return "http://farm" + photo_info.farm + ".staticflickr.com/" + photo_info.server + "/" + photo_info.id + "_" + photo_info.secret + "_" + size + ".jpg";
	},
	getPhotos: function( album_id, callback ) {
		var _this = this, size = "q";
		this.get({ method: this.api.photosets.getPhotos, photoset_id: album_id, media: "photos", privacy_filter: 1 }, "photoset", function( photos ) {
			$.each( photos.photo, function( idx, photo ) {
				photos.photo[idx]["url"] = _this.getPhotoUrl(photo, size);
			});
			callback.call(win, photos);
		});
	},
	getPhotoSize: function( photo_id, callback ) {
		this.get({ method: this.api.photos.getSizes, photo_id: photo_id }, "sizes", callback);
	},
	getPhotoEXIF: function( photo_id, callback ) {
		this.get({ method: this.api.photos.getExif, photo_id: photo_id }, "photo", callback);
	},
	getPhotoInfo: function( photo_id, callback ) {
		this.get({ method: this.api.photos.getInfo, photo_id: photo_id }, "photo", callback);
	},
	getContacts: function() {
		this.get({ method: this.api.contacts.getList }, "contact");
	}
});

$.extend( Flickr, {
	album: function() {
		var id = arguments[0], callback = arguments[1], displayPhotoList = arguments[2];
		
		if ( $.isFunction(id) ) {
			displayPhotoList = callback;
			callback = id;
		}
		
		$.isNumeric(id) ? FP.getAlbum(id, callback, displayPhotoList) : FP.getAllAlbum(callback, displayPhotoList);
	},
	cover: function( album_id, callback ) {
		if ( $.isNumeric(album_id) ) {
			FP.getCover(album_id, callback);
		}
		else if ( $.isFunction(callback) )
			callback.call(win, "#");
	},
	albumPhotos: function( album_id, callback ) {
		FP.getPhotos(album_id, callback);
	},
	photoInfo: function( photo_id, callback ) {
		FP.getPhotoInfo(photo_id, callback);
	},
	size: function( photo_id, callback ) {
		FP.getPhotoSize(photo_id, callback);
	},
	exif: function( photo_id, callback ) {
		FP.getPhotoEXIF(photo_id, callback);
	},
	contacts: function() {
		FP.getContacts();
	}
});

window.Flickr = Flickr;
	
})();