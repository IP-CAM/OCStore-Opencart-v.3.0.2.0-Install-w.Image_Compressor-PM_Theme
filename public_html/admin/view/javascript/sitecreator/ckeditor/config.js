/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'en';
	// config.uiColor = '#AADC6E';

  config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'NewPage,Cut,Copy,Paste,PasteText,PasteFromWord,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Styles';

  // https://github.com/w8tcha/CKEditor-CodeMirror-Plugin
  // https://ckeditor.com/cke4/addon/codemirror
  config.extraPlugins = 'codemirror, htmlwriter';
  config.codemirror = {
    theme: 'oceanic-next',
    enableSearchTools: false,
    showFormatButton: false
  };
  config.dataIndentationChars = '  ';
  config.allowedContent = true;
  config.height = 400;
  config.enterMode = CKEDITOR.ENTER_BR;
};



// Добавление возможности вставки вырезаемых тегов внутрь a
// https://github.com/ckeditor/ckeditor4/issues/514
const extraTagsInsideATag = {
  picture: 1,
  source: 1,
  div: 1,
  p: 1,
  h2: 1,
  h3: 1,
  h4: 1,
  h5: 1,
  h6: 1
};
Object.assign(CKEDITOR.dtd['a'], extraTagsInsideATag);
CKEDITOR.dtd.$block['a'] = 1; // делаем a блочным, для предотвращения появления лишних пробелов внутри (не проверялось)

const extraTagsInsideDivPTag = {
  picture: 1,
  source: 1
};
Object.assign(CKEDITOR.dtd['div'], extraTagsInsideDivPTag);
Object.assign(CKEDITOR.dtd['p'], extraTagsInsideDivPTag);


// picture может содержать теги
CKEDITOR.dtd['picture'] = {
  source: 1,
  img: 1
};
CKEDITOR.dtd.$block['picture'] = 1; // делаем блочным


CKEDITOR.on( 'instanceReady', function( ev ) {
  var writer = ev.editor.dataProcessor.writer;

  writer.selfClosingEnd = '>';

  writer.setRules( 'p', {
      indent: true,
      breakBeforeOpen: true,
      breakAfterOpen: false,
      breakBeforeClose: false,
      breakAfterClose: false
  });

  writer.setRules( 'div', {
      indent: true,
      breakBeforeOpen: true,
      breakAfterOpen: true,
      breakBeforeClose: true,
      breakAfterClose: false
  });

  writer.setRules( 'span', {
      indent: true,
      breakBeforeOpen: true,
      breakAfterOpen: false,
      breakBeforeClose: false,
      breakAfterClose: false
  });

  writer.setRules( 'a', {
      indent: true,
      breakBeforeOpen: true,
      breakAfterOpen: true,
      breakBeforeClose: true,
      breakAfterClose: false
  });

  writer.setRules( 'img', {
      breakBeforeOpen: true
  });

  writer.setRules( 'h1', {
      breakAfterClose: false,
  });

  writer.setRules( 'h2', {
      breakAfterClose: false,
  });

  writer.setRules( 'h3', {
      breakAfterClose: false,
  });

  writer.setRules( 'h4', {
      breakAfterClose: false,
  });

  writer.setRules( 'h5', {
      breakAfterClose: false,
  });

  writer.setRules( 'h6', {
      breakAfterClose: false,
  });

  writer.setRules( 'ul', {
      breakAfterClose: false
  });

  writer.setRules( 'ol', {
      breakAfterClose: false
  });

  writer.setRules( 'li', {
    indent: true,
    breakBeforeClose: true
});

  writer.setRules( 'article', {
      indent: true,
      breakBeforeOpen: true,
      breakAfterOpen: true,
      breakBeforeClose: true,
      breakAfterClose: true
  });

  writer.setRules( 'section', {
      indent: true,
      breakBeforeOpen: true,
      breakAfterOpen: true,
      breakBeforeClose: true,
      breakAfterClose: true
  });

  writer.setRules( 'picture', {
      indent: true,
      breakBeforeOpen: true,
      breakAfterOpen: true,
      breakBeforeClose: true,
      breakAfterClose: false
  });

  writer.setRules( 'source', {
      breakBeforeOpen: true
  });

});
