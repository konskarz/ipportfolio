<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();

$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');

$doc->addStyleSheet('templates/'.$this->template.'/css/custom.css');
JHtml::_('bootstrap.loadCss', false, $doc->direction);
JHtml::_('bootstrap.framework');

$this->setGenerator(null);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $doc->language; ?>" lang="<?php echo $doc->language; ?>" dir="<?php echo $doc->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/apple-touch-icon-144x144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/apple-touch-icon-57x57-precomposed.png">
</head>

<body class="site <?php echo $option
. ' view-' . $view
. ($layout ? ' layout-' . $layout : ' no-layout')
. ($task ? ' task-' . $task : ' no-task')
. ($itemid ? ' itemid-' . $itemid : '');
?>" data-grid-framework="bo" data-grid-color="black" data-grid-opacity="0.1" data-grid-zindex="999" data-grid-nbcols="12">
<!-- ToDo: remove data- attributes and comment
Framework codes: b3 (Bootstrap 3), bo (Bootstrap 2 fixed), bf (Bootstrap 2 fluid), f4 (Foundation 4), f3 (Foundation 3), f2 (Foundation 2).
Note: 'Nb cols' parameter for Bootstrap only.
-->

<div class="container">
	<div class="header clearfix">
		<div class="pull-left">
			<a class="brand" href="<?php echo $this->baseurl; ?>"><?php echo $app->getCfg('sitename'); ?></a>
		</div>
		<div class="pull-right">
			<jdoc:include type="modules" name="position-0" style="none" />
		</div>
	</div>
	<div class="row">
		<div class="span8">
			<jdoc:include type="modules" name="position-1" style="none" />
			<jdoc:include type="message" />
			<jdoc:include type="component" />
			<jdoc:include type="modules" name="position-2" style="none" />
		</div>
		<div class="span3 offset1">
			<jdoc:include type="modules" name="position-7" style="none" />
		</div>
	</div>
	<p>
		&copy; <?php echo $app->getCfg('sitename'); ?> <?php echo date('Y');?>
	</p>
</div>

<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/template.js"></script>
</body>
</html>