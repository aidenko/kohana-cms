jQuery(document).ready(function(){
	jQuery(".language-selector .arrow-item").click(function(){
		var oSelector = jQuery(".language-selector");
		var oItems = jQuery(".language-selector-items");
		/*if(oItems.hasClass("view"))
		{
			oItems.removeClass("view");
		}else
			oItems.addClass("view");*/
			
		if(oSelector.hasClass("view-list"))
			oSelector.removeClass("view-list");
		else
			oSelector.addClass("view-list");		
		
	});
});
