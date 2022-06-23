<?php
defined('_JEXEC') or die;
$doc = JFactory::getDocument();
?>
<ul class="nav ippager">
<?php if ($row->prev->link && $row->prev->title) :
	$doc->addCustomTag('
	<link rel="prefetch" href="'. $row->prev->link . '" />
	<link rel="dns-prefetch" href="'. $row->prev->link . '" />
	<link rel="prerender" href="'. $row->prev->link . '" />
	');
?>
	<li class="previous">
		<a href="<?php echo $row->prev->link; ?>" rel="prev">
			<span class="icon-arrow-left"></span>
			<span class="hide"><?php echo $row->prev->title; ?></span>
		</a>
	</li>
<?php endif; ?>
<?php if ($row->next->link && $row->next->title) :
	$doc->addCustomTag('
	<link rel="prefetch" href="'. $row->next->link . '" />
	<link rel="dns-prefetch" href="'. $row->next->link . '" />
	<link rel="prerender" href="'. $row->next->link . '" />
	');
?>
	<li class="next">
		<a href="<?php echo $row->next->link; ?>" rel="next">
			<span class="icon-arrow-right"></span>
			<span class="hide"><?php echo $row->next->title; ?></span>
		</a>
	</li>
<?php endif; ?>
</ul>
