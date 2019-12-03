/**

 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.

 * For licensing, see LICENSE.html or http://ckeditor.com/license

 */



CKEDITOR.editorConfig = function( config ) {

	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	
	config.width = "auto";
   
	
	//config.forcePasteAsPlainText = true;
	config.toolbar = 'Personalizada';
    config.toolbar_Personalizada =
    [
		['FontSize','-','Bold','Italic','Underline','Strike'],
		['Subscript','Superscript','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['NumberedList','BulletedList','Link','Unlink'],
		'/',
		['TextColor','BGColor','-','Cut','Copy','Paste','PasteFromWord'],
		['Outdent','Indent','Undo','Redo','Table','HorizontalRule','-','Source']
    ];
	
	config.toolbar = 'Simples';
    config.toolbar_Simples =
    [
		['FontSize','-','Bold','Italic','Underline','Strike'],
		['Subscript','Superscript','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['NumberedList','BulletedList','Link','Unlink'],
		['Cut','Copy','Paste','PasteFromWord'],
		['Outdent','Indent','Undo','Redo','HorizontalRule']
    ];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	//config.removeButtons = 'Underline,Subscript,Superscript';

};

