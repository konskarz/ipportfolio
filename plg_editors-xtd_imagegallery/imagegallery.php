<?php
defined('_JEXEC') or die('Restricted access');

class plgButtonImageGallery extends JPlugin
{
	protected $autoloadLanguage = true;

	public function onDisplay($name)
	{
		$js = "
			function insertGallery(path, editor) {
				jInsertEditorText('{gallery}' + path + '{/gallery}', editor);
				return false;
			}
			";
		JFactory::getDocument()->addScriptDeclaration($js);

		$url = JPATH_SITE . '/images';
		$data = str_replace($url.'/', '', $this->read_recursiv($url));
		
		$html = array();
		$html[] = '<a class="btn" data-toggle="modal" data-target="#imagegallery-modal-' . $name . '"><i class="icon-pictures"></i> '
			. JText::_('PLG_EDITORS-XTD_IMAGEGALLERY_BUTTONTEXT') . '</a>';
		$html[] = '<div id="imagegallery-modal-' . $name . '" class="modal hide fade" tabindex="-1" style="font-size: 14px;">';
		$html[] = '
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>' . JText::_('PLG_EDITORS-XTD_IMAGEGALLERY_SELECTFOLDER') . '</h3>
			</div>
			<div class="modal-body"><ul class="nav nav-tabs nav-stacked">
		';
		foreach($data as $value)
		{
			$html[] = '<li><a href="#" onclick="insertGallery(\'' . $value . '\', \'' . $name . '\');" data-dismiss="modal">' . $value . '</a></li>';
		}
		$html[] = '</ul></div></div>';
		$html = '" style="display:none;" class="btn"></a>'
			. implode('', $html)
			. '<a style="display:none;" class="btn';

		$button = new JObject;
		$button->name = 'imagegallery';
		$button->options = $html;
		return $button;
	}
	
	function read_recursiv($path)
	{
		$result = array();
		if($handle = @opendir($path))
		{
			while(($file = readdir($handle)) !== false)
			{
				if($file != "." && $file != ".." && is_dir($path."/".$file))
				{
					$result = array_merge($result, $this->read_recursiv($path."/".$file));
					$result[] = $path."/".$file;
				}
			}
			closedir($handle);
		}
		sort($result);
		return $result;
	}
}
