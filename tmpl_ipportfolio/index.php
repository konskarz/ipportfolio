<?php

defined('_JEXEC') or die;
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$user = JFactory::getUser();

$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$ippager  = $app->input->getRaw('ippager', '');
$logout   = $user->id ? JRoute::_('index.php?option=com_users&task=user.logout') . '&'
	. JSession::getFormToken() . '=1&return=' . base64_encode(JURI::current()) : false;

$doc->addStyleSheet('templates/'.$this->template.'/css/custom.css');
JHtml::_('bootstrap.loadCss', false, $doc->direction);
JHtml::_('bootstrap.framework');

$this->setGenerator(null);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $doc->language; ?>" lang="<?php echo $doc->language; ?>" dir="<?php echo $doc->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+('devicePixelRatio' in window ? ','+devicePixelRatio : ',1')+'; path=/';</script>
	<jdoc:include type="head" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-152.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-144.png">
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-120.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-114.png">
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-76.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-72.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-ios6-57.png">
	<link rel="icon" sizes="32x32" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-32.png">
	<link rel="shortcut icon" sizes="195x195" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-195.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-win-144.png">
	<meta name="msapplication-square70x70logo" content="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-win-70.png"/>
	<meta name="msapplication-square150x150logo" content="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-win-150.png"/>
	<meta name="msapplication-wide310x150logo" content="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-win-310x150.png"/>
	<meta name="msapplication-square310x310logo" content="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/img/favicon-win-310.png"/>
</head>

<body class="site <?php echo $option
. ' view-' . $view
. ($layout ? ' layout-' . $layout : ' no-layout')
. ($task ? ' task-' . $task : ' no-task')
. ($itemid ? ' itemid-' . $itemid : '');
/*
ToDo: remove data- attributes and comment
Framework codes: b3 (Bootstrap 3), bo (Bootstrap 2 fixed), bf (Bootstrap 2 fluid), f4 (Foundation 4), f3 (Foundation 3), f2 (Foundation 2).
Note: 'Nb cols' parameter for Bootstrap only.
*/
?>" data-grid-framework="bo" data-grid-color="black" data-grid-opacity="0.1" data-grid-zindex="999" data-grid-nbcols="12">

<div id="header" class="header clearfix">
	<div class="pull-left">
		<ul class="nav menu">
			<li><a class="brand" href="<?php echo $this->baseurl; ?>">
				<?php echo $app->getCfg('sitename'); ?></a></li>
			<li><a href="#footer">Cases</a></li>
			<?php if($logout) : ?>
				<li><a href="<?php echo $logout; ?>">Logout</a></li>
			<?php endif; ?>
		</ul>
		<jdoc:include type="modules" name="position-0" style="none" />
	</div>
	<?php if($ippager) : ?>
		<div class="pull-right">
			<?php echo $ippager; ?>
		</div>
	<?php endif; ?>
</div>

<?php if($view == "article") : ?>
<jdoc:include type="component" />
<?php else : ?>
<div class="front-end container">
	<jdoc:include type="component" />
</div>
<?php endif; ?>

<div id="footer" class="footer">
	<jdoc:include type="modules" name="position-7" style="none" />
	<jdoc:include type="modules" name="position-1" style="none" />
</div>

<jdoc:include type="message" />
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/jquery.hammer.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/scroll-up-bar.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/template.js"></script>
</body>
</html>