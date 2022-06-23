<?php
defined('_JEXEC') or die('Restricted access');

class plgContentImageGallery extends JPlugin
{
	function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$regex = '@{gallery}(.*){/gallery}@Us';
		if(!preg_match($regex, $article->text))
		{
			return;
		}
		preg_match_all($regex, $article->text, $matches, PREG_PATTERN_ORDER) > 0;
		
		$count = 0;

		foreach($matches[0] as $match)
		{
			$count++;
			$options = preg_replace('@{.+?}@', '', $match);
			$matcheslist = explode(',', $options);
			$path = $matcheslist[0];
			$layout = isset($matcheslist[1]) ? $matcheslist[1] : 'default';
			unset($matcheslist);
			
			$id = str_replace('/', '-', $path);
			$name = substr(strrchr($path, "/"), 1) != '' ? substr(strrchr($path, "/"), 1) : $path;
			$dir = 'images/'.$path;
			$txtfile = false;

			$txt_lang = JPATH_SITE.'/'.$dir.'/'.$name.'-'.JFactory::getLanguage()->getTag().'.txt';
			$txt = JPATH_SITE.'/'.$dir.'/'.$name.'.txt';
			if(file_exists($txt_lang))
			{
				$txtfile = $txt_lang;
			}
			elseif(file_exists($txt))
			{
				$txtfile = $txt;
			}
			
			unset($images);
			$noimage = 0;
			if($txtfile)
			{
				$captions_file = array_map('trim', file($txtfile));
				foreach($captions_file as $value)
				{
					if(!empty($value))
					{
						$rows[] = explode('|', $value);
						foreach($rows as $key => $row)
						{
							$images[] = (object) array(
								'filename' => $dir.'/'.$row[0],
								'alt' => substr($row[0], 0, -4),
								'title' => isset($row[1]) ? $row[1] : '',
								'description' => isset($row[2]) ? $row[2] : '',
								'link' => isset($row[3]) ? $row[3] : ''
							);
							$noimage++;
							unset($rows[$key]);
							break;
						}
					}
				}
			}
			
			elseif($dh = @opendir(JPATH_SITE.'/'.$dir))
			{
				while(($file = readdir($dh)) !== false)
				{
					$ext = substr(strtolower($file), -3);
					if($ext == 'jpg' || $ext == 'gif' || $ext == 'png')
					{
							$images[] = (object) array(
								'filename' => $dir.'/'.$file,
								'alt' => substr($file, 0, -4)
							);
							$noimage++;
					}
				}
				closedir($dh);
				sort($images);
			}

			if($noimage)
			{
				$layoutpath = JPluginHelper::getLayoutPath('content', 'imagegallery', $layout);
				ob_start();
				include $layoutpath;
				$html = ob_get_clean();
			}
			else
			{
				$html = '<strong>'.JText::_('NOIMAGES').'</strong><br /><br />'.JText::_('NOIMAGESDEBUG').' '.$dir;
			}

			$article->text = preg_replace('@(<p>)?{gallery}'.$options.'{/gallery}(</p>)?@s', $html, $article->text);
			
		}
		
	}

}
