var oComment = {
	
	'quote': function(commentId)
	{
		var oEditor = CKEDITOR.instances.cm_text;

    var sStr = '<fieldset><legend>' + jQuery('.name', jQuery('[data-commentid="' + commentId + '"]')).html() + '</legend>'
                + jQuery('.text', jQuery('[data-commentid="' + commentId + '"]')).html()
                + '</fieldset>';

    oEditor.insertElement(CKEDITOR.dom.element.createFromHtml(sStr, oEditor.document));
    oEditor.insertElement(CKEDITOR.dom.element.createFromHtml('<p>&nbsp;</p>', oEditor.document));
	},
	
	'init': function()
	{
		CKEDITOR.replace('cm_text', {
			'customConfig': '/assets/js/ck-editor-modulecomment.js'
		});
	}

};