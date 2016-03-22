/*
 * date:2011/04/28
 * Social Medias Connect Plug-in
 */
if(!$||$ !== jQuery)$=jQuery;
$(document).ready(function(){
	$('#smc_shorturl_service').change(function(){
		if($('option:selected',this).val()=='custom'){
			$('#smc_shorturl').fadeIn();
		}else{
			$('#smc_shorturl').fadeOut();
		}
	});
});

