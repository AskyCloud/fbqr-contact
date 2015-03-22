/*
 * Ajaxify - jQuery Plugin
 * version: 1.00 (3/10/2008)
 * Created by: MaX
 * Examples and documentation at: http://max.jsrhost.com/ajaxify-jquery-plugin/
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 */
(function($){ 
$.fn.ajaxify = function(options) {
var defaults = {  
		event:'click', //specify the event
		link:false, // specify the link, priority is for the href attr.
		target:'body', //the data loaded via ajax will be placed here
		method: 'GET', // the request method GET or POST
		tagToload:false, // inserts just the tag from the data loaded, it can be specified as t a second argument in the 'target' attr(#box,#result)
		loading_image:'/ajaxify/loading.gif', // doesn't need to explain
		loadHash:false, // for use this to resolve bookmarking issues, see example for more details
		params:'ajax=true', //extend parameters for the webpage. usually this option used to check weather the client accessed the page by normal method or by ajax
		timeout:false, //in ms.  there is a problem in this option on linux servers
		contentType:"application/x-www-form-urlencoded",
		dataType:'html',
		cache:false, // force the browser not to cache
		username:false, //username HTTP access authentication
		password:false, //password HTTP access authentication
		onStart:function(){}, // a callback function before start requesting.
		onError:function(){}, // a callback function if error happened while requesting
		onSuccess:function(){},// a callback function if the request finished successfuly
		onComplete:function(){}//a callback function when the request finished weather it was a successful one or not.
	};
	// merge the unspecified options with the defaults
	var current = $.extend(defaults, options);
	return this.each(function() {
	// check if there is a hash on the page
		$(this).ajaxify_loadHash(current);
		//bind the event
			//prepare the data
			$(this).bind(current.event,function(){
			current.link = $(this).attr('href').replace(/^#/, "") || current.link;
			var tempWhere = $(this).attr('target').split(',');
			current.where = tempWhere[0] || current.target;
			current.tagToload = tempWhere[1] || current.tagToload;
			//load the page
			$(this).ajaxify_load(current);
			return false;

			});
	});
};


$.fn.ajaxify_load = function(current) {
	// turn off globals 
	$.ajaxSetup({global:false});
	//append the loading img
	$(current.where).html("<img src='" + current.loading_image + "' alt='Loading...' title='Loading...'>");
	


	
	//start calling  $.ajax function. thank you jquery for making this easy
	$.ajax({
		  type: current.method,
		  url: current.link,
		  dataType: current.dataType,
		  data: current.params,
		  contentType:current.contentType,
		  timeout:current.timeout,
		  cache:current.cache,
		  username:current.username,
		  password:current.password,
		  error:current.onError,
		  complete: current.onComplete,
		  beforeSend: current.onStart,
		  success: function(data){
		  if(current.tagToload){
			$(current.where).html('<div id="temp" style="display:none">'+data+'</div>');			
			data = $('#temp').find(current.tagToload);
			$('#temp').remove();
		  }
		  $(current.where).html(data);
		  current.onSuccess();
		  }
		});
		
			//insert the link in the hash if loadHash was enabled
	if(current.loadHash)
		location.hash = current.link;		
	else if(location.hash.length > 1){
	document.location.hash = "#";// i know its ugly, if you came up with a better solution, tell me
	return false; // Cancel any event from this point forward
	}
}; 

$.fn.ajaxify_loadHash = function(current){
//if loadHash enabled and there is a url in the hash , load it
	if(current.loadHash && location.hash.replace(/^#/, "")){
		current.where = current.target;
		current.link = location.hash.replace(/^#/, "");
		$(current.target).ajaxify_load(current);
		return true;
	}else
		return false;
};

})(jQuery);