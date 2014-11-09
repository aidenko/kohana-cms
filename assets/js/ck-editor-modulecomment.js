CKEDITOR.editorConfig = function( config ) {

	config.toolbarGroups = [
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent'] },
	];

	config.removeButtons = 'Anchor,Subscript,Superscript';

	config.format_tags = 'p;h1;h2;h3;pre';

	config.removeDialogTabs = 'image:advanced;link:advanced';
	
	config.extraPlugins = 'codesnippetgeshi';
	config.codeSnippetGeshi_url = '/action/geshi';
};