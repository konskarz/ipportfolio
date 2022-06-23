function IeCursorFix() {
    return true;
}

function jInsertEditorText(text, editor) {
    mcecm.insert(editor, text);
}

(function() {
	
	window.mcecm = {
		cm: false,

		cmoptions: {
			mode: 'application/x-httpd-php',
			smartIndent: true,
			lineNumbers: true,
			autoCloseBrackets: true,
			autoCloseTags: true,
			matchTags: true,
			matchBrackets: true,
			foldGutter: true,
			gutters: [
				'CodeMirror-linenumbers',
				'CodeMirror-foldgutter'
			],
			lineWrapping: true,
			tabMode: 'shift',
			extraKeys: {
				'Ctrl-Q': function(cm) {
					setFullScreen(cm, !isFullScreen(cm))
				},
				'Esc': function(cm) {
					if (isFullScreen(cm)) setFullScreen(cm, false)
				}
			}
		},
		
		init: function(settings) {
			tinymce.extend(settings, {
				plugins: [
					'fullscreen',
					'link',
					'paste',
				].toString(),
				menubar: false,
				toolbar: [
					'fullscreen',
					'undo',
					'redo',
					'|',
					'cut',
					'copy',
					'pastetext',
					'removeformat',
					'|',
					'formatselect',
					'|',
					'link',
					'unlink',
				].toString(),
		        formats: {
					body: {block: 'p', attributes: {'class': ''}},
					last: {selector: 'p,tr,dd', classes: 'last'},
					h3: {block : 'h3', attributes: {'class': ''}},
		        },
				block_formats: 'body=body;last=last;h3=h3',
			    target_list: [{title: 'None', value: ''}],
				body_class: 'item-page',
				entities: '160,nbsp',
				object_resizing: false,
				preview_styles: false,
				visual: false,
			});
			tinymce.init(settings);
		},
		
		insert: function(editor, text) {
			var ed = tinymce.get(editor);
			if(this.cm) {
				this.cm.replaceSelection(text);
			}
			else {
				ed.execCommand('mceInsertContent', false, text);
			}
		},
		
		setContent: function(editor, text) {
			var ed = tinymce.get(editor);
			if(this.cm) {
				this.cm.setValue(text);
			}
			else {
				ed.setContent(text);
			}
		},
		
		getContent: function(editor) {
			var ed = tinymce.get(editor);
			if(this.cm) {
				this.cm.getValue();
			}
			else {
				ed.getContent();
			}
		},
		
		save: function(editor) {
			var ed = tinymce.get(editor);
			if(this.cm) {
				this.cm.toTextArea();
				this.cm = false;
				ed.show();
			}
			ed.save();
		},
		
		toggle: function(editor) {
			var ed = tinymce.get(editor);
			if(this.cm) {
				this.cm.toTextArea();
				this.cm = false;
				ed.show();
			}
			else {
				ed.hide();
				this.cm = CodeMirror.fromTextArea(document.getElementById(editor), this.cmoptions);
			}
		},
	};
		
	tinymce.on('AddEditor', function(e) {
		var ed = e.editor;
		
		ed.on('BeforeGetContent', function(e) {
			var s;
			if(e.save) {
				// set empty alt attribute to the image’s filename
				tinymce.each(ed.dom.select('img[alt=""]'), function(el) {
					s = ed.dom.getAttrib(el, 'src');
					ed.dom.setAttrib(el, 'alt', s.substring(s.lastIndexOf('/') + 1, s.lastIndexOf('.')));
				});
			}
		});
		
		ed.on('SaveContent', function(e) {
			// remove empty p, h3, div
			e.content = e.content.replace(/<(p|h3|div)\b[^>]*>(&nbsp;)*\s*<\/\1>/gim, '');
		});
		
	});
	
})();

/**
* Events
ed.on('BeforeRenderUI', function(e) {console.debug('BeforeRenderUI')});
ed.on('PreInit', function(e) {console.debug('PreInit')});
ed.on('BeforeSetContent', function(e) {console.debug('BeforeSetContent')});
ed.on('LoadContent', function(e) {console.debug('LoadContent')});
ed.on('BeforeGetContent', function(e) {console.debug('BeforeGetContent');});
ed.on('GetContent', function(e) {console.debug('GetContent')});
ed.on('init', function(e) {console.debug('init')});

ed.on('BeforeGetContent', function(e) {if(e.save) console.debug('BeforeGetContent')});
ed.on('PreProcess', function(e) {if(e.save) console.debug('PreProcess')});
ed.on('PostProcess', function(e) {if(e.save) console.debug('PostProcess')});
ed.on('GetContent', function(e) {if(e.save) console.debug('GetContent')});
ed.on('SaveContent', function(e) {console.debug('SaveContent')});

ed.on('BeforeExecCommand', function(e) {console.debug(e.command)});
ed.on('ExecCommand', function(e) {console.debug(e.command)});
*/

/**
* Plugins
plugins: [
	'advlist',
	'anchor',
	'autolink',
	// 'autoresize',
	// 'autosave',
	// 'bbcode',
	'charmap',
	'code',
	'colorpicker',
	'contextmenu',
	'directionality',
	'emoticons',
	// 'fullpage',
	'fullscreen',
	'hr',
	'image',
	'importcss',
	'insertdatetime',
	'layer',
	'legacyoutput',
	'link',
	'lists',
	'media',
	'nonbreaking',
	'noneditable',
	'pagebreak',
	'paste',
	'preview',
	'print',
	'save',
	'searchreplace',
	'spellchecker',
	'tabfocus',
	'table',
	'template',
	'textcolor',
	'textpattern',
	'visualblocks',
	'visualchars',
	'wordcount',
].toString(),
*/

/** 
* Controls
// Edit
toolbar1: [
	'newdocument',
	'save',
	'cancel',
	'undo',
	'redo',
	'cut',
	'copy',
	'paste',
	'pastetext',
	'searchreplace',
	'fullscreen',
	'visualchars',
	'visualblocks',
	'spellchecker',
	'preview',
	'print',
	'code',
	// 'fullpage',
].toString(),
// Style
toolbar2: [
	'styleselect',
	'fontselect',
	'fontsizeselect',
	'forecolor',
	'backcolor',
	'alignleft',
	'aligncenter',
	'alignright',
	'alignjustify',
	'outdent',
	'indent',
	'removeformat',
].toString(),
// Elements
toolbar3: [
	'formatselect',
	'blockquote',
	'bullist',
	'numlist',
	'bold',
	'italic',
	'underline',
	'strikethrough',
	'subscript',
	'superscript',
	'link',
	'unlink',
	'ltr',
	'rtl',
].toString(),
// Insert
toolbar4: [
	'nonbreaking',
	'charmap',
	'emoticons',
	'insertdatetime',
	'anchor',
	'pagebreak',
	'hr',
	'image',
	'media',
	'table',
	'template',
].toString(),
*/

/**
* Debug settings
ed.on('init', function(e) {
	var output = [];
	for (property in ed.settings) {
		output.push(property + ': ' + ed.settings[property]);
	}
	console.debug(output.join(',\r\n'));
});
*/