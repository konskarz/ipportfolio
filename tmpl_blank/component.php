<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();

$doc->addStyleSheet('templates/'.$this->template.'/css/custom.css');
JHtmlBootstrap::loadCss($includeMaincss = false, $doc->direction);
JHtml::_('bootstrap.framework');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $doc->language; ?>" lang="<?php echo $doc->language; ?>" dir="<?php echo $doc->direction; ?>">
<head>
	<jdoc:include type="head" />
</head>

<body class="contentpane modal">

<jdoc:include type="message" />
<jdoc:include type="component" />

</body>
</html>
