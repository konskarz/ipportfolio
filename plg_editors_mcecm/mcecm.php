<?php
defined('_JEXEC') or die('Restricted access');

class PlgEditorMcecm extends JPlugin
{
	/**
	 * Base path for editor files
	 */
	protected $_basePath = 'media/editors/';

	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Loads the application object
	 *
	 * @var    JApplicationCms
	 * @since  3.2
	 */
	protected $app = null;

	/**
	 *Default template for the site application
	 *
	 * @var    string template name
	 */
	protected $template = null;
	 
	/**
	 * Initialises the Editor.
	 *
	 * @return  string  JavaScript Initialization string
	 *
	 * @since 1.5
	 */
	public function onInit()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('template')
			->from('#__template_styles')
			->where('client_id=0 AND home=' . $db->quote('1'));
		$db->setQuery($query);
		$this->template = 'templates/' . $db->loadResult();

		// CodeMirror
		JHtml::_('behavior.framework');
		$parserFile = array(
			'codemirror.js',
			'fullscreen.js',
			'brace-fold.js',
			'xml-fold.js',
			'xml.js',
			'clike.js',
			'css.js',
			'javascript.js',
			'htmlmixed.js',
			'php.js',
			'closebrackets.js',
			'closetag.js',
			'matchtags.js',
			'matchbrackets.js',
			'foldcode.js',
			'foldgutter.js'
		);
		foreach ($parserFile as $file)
		{
			JHtml::_('script', $this->_basePath . 'codemirror/js/' . $file, false, false, false, false);
		}
		JHtml::_('stylesheet', $this->_basePath . 'codemirror/css/codemirror.css');

		$editor_css = $this->params->def('editor_css', $this->_name . '.css');
		$editor_css = file_exists(JPATH_SITE . '/' . $this->template . "/css/$editor_css") ?
			$this->template . "/css/$editor_css" : 
			$this->_basePath . 'codemirror/css/configuration.css';
		JHtml::_('stylesheet', $editor_css);
		
		// TinyMCE
		JHtml::_('script', $this->_basePath . 'tinymce/tinymce.min.js', false, false, false, false);
		$editor_js = $this->params->def('editor_js', $this->_name . '.js');
		$editor_js = file_exists(JPATH_SITE . '/' . $this->template . "/js/$editor_js") ?
			$this->template . "/js/$editor_js" : 
			'plugins/editors/' . $this->_name . '/' .  $this->_name . '.js';
		JHtml::_('script', $editor_js, false, false, false, false);
		
		return '';
	}

	/**
	 * Get the editor content
	 *
	 * @param   string  $editor  The name of the editor
	 *
	 * @return  string
	 */
	public function onGetContent($editor)
	{
		return "mcecm.getContent('$editor');";
	}

	/**
	 * Set the editor content
	 *
	 * @param   string  $editor  The name of the editor
	 * @param   string  $html    The html to place in the editor
	 *
	 * @return  string
	 */
	public function onSetContent($editor, $html)
	{
		return "mcecm.setContent('$editor', $html);";
	}

	/**
	 * Copy editor content to form field
	 *
	 * @param   string  $editor  The name of the editor
	 *
	 * @return  string
	 */
	public function onSave($editor)
	{
		return "mcecm.save('$editor');";
	}

	/**
	 * Inserts html code into the editor
	 *
	 * @param   string  $name  The name of the editor
	 *
	 * @return  boolean
	 */
	public function onGetInsertMethod($name)
	{
		return true;
	}

	/**
	 * Display the editor area.
	 *
	 * @param   string   $name     The name of the editor area.
	 * @param   string   $content  The content of the field.
	 * @param   string   $width    The width of the editor area.
	 * @param   string   $height   The height of the editor area.
	 * @param   int      $col      The number of columns for the editor area.
	 * @param   int      $row      The number of rows for the editor area.
	 * @param   boolean  $buttons  True and the editor buttons will be displayed.
	 * @param   string   $id       An optional ID for the textarea. If not supplied the name is used.
	 * @param   string   $asset    The object asset
	 * @param   object   $author   The author.
	 *
	 * @return  string
	 */
	public function onDisplay($name, $content, $width, $height, $col, $row,
		$buttons = true, $id = null, $asset = null, $author = null)
	{
		if (empty($id))
		{
			$id = $name;
		}

		// Only add "px" to width and height if they are not given as a percentage
		if (is_numeric($width))
		{
			$width .= 'px';
		}

		if (is_numeric($height))
		{
			$height .= 'px';
		}

		$settings = new stdClass;
		$settings->editor_selector = 'mce_editable';
		$settings->mode = 'specific_textareas';
		$settings->document_base_url = JUri::root();

		$language = JFactory::getLanguage();
		$settings->language = 'en';
		$langCode = substr($language->getTag(), 0, strpos($language->getTag(), '-'));
		if (file_exists(JPATH_SITE . '/' . $this->_basePath . 'tinymce/langs/' . $language->getTag() . '.js')) {
			$settings->language = $language->getTag();
		}
		elseif (file_exists(JPATH_SITE . '/' . $this->_basePath . 'tinymce/langs/' . $langCode . '.js')) {
			$settings->language = $langCode;
		}
		$settings->directionality = $language->isRTL() ? 'rtl' : 'ltr';
		
		$content_css = $this->params->def('content_css', 'template.css');
		if(file_exists(JPATH_SITE . '/' . $this->template . "/css/$content_css")) {
			$settings->content_css = JUri::root() . $this->template . "/css/$content_css";
		}
		
		$settings = json_encode($settings);
		JFactory::getDocument()->addScriptDeclaration($this->_name . ".init($settings)");
		
		$return = array();
		$return[] = '<div class="editor">';
		$return[] = '<textarea name="' . $name . '" ';
		$return[] = 'id="' . $id .'" ';
		$return[] = 'cols="' . $col .'" ';
		$return[] = 'rows="' . $row .'" ';
		$return[] = 'style="width: ' . $width . ';height:' . $height . ';" ';
		$return[] = 'class="mce_editable">';
		$return[] = $content;
		$return[] = '</textarea>';
		$return[] = $this->_displayButtons($id, $buttons, $asset, $author);
		$return[] = $this->_toogleButton($id);
		$return[] = '</div>';
		$return = implode('', $return);

		return $return;
	}

	/**
	 * Displays the editor buttons.
	 *
	 * @param   string  $name     The editor name
	 * @param   mixed   $buttons  [array with button objects | boolean true to display buttons]
	 * @param   string  $asset    The object asset
	 * @param   object  $author   The author.
	 *
	 * @return  string HTML
	 */
	private function _displayButtons($name, $buttons, $asset, $author)
	{
		$return = '';
		
		$args = array(
			'name'  => $name,
			'event' => 'onGetInsertMethod'
		);

		$results = (array) $this->update($args);

		if ($results)
		{
			foreach ($results as $result)
			{
				if (is_string($result) && trim($result))
				{
					$return .= $result;
				}
			}
		}

		if (is_array($buttons) || (is_bool($buttons) && $buttons))
		{
			$buttons = $this->_subject->getButtons($name, $buttons, $asset, $author);
			$return .= JLayoutHelper::render('joomla.editors.buttons', $buttons);
		}

		return $return;
	}

	/**
	 * Get the toggle editor button
	 *
	 * @param   string  $name  Editor name
	 *
	 * @return  string
	 */
	private function _toogleButton($name)
	{
		$onclick = "mcecm.toggle('$name');return false;";
		$return = array();
		$return[] = '<div class="toggle-editor btn-toolbar pull-right clearfix"><div class="btn-group">';
		$return[] = '<a class="btn" href="#" onclick="' . $onclick . '" title="Toggle editor">';
		$return[] = '<i class="icon-eye"></i> Toggle editor</a></div></div>';
		$return = implode('', $return);

		return $return;
	}
}
