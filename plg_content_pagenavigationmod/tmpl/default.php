<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagenavigation
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="pager pagenav">
<?php if ($row->prev->link && $row->prev->title) : ?>
	<li class="previous">
		<a href="<?php echo $row->prev->link; ?>" rel="prev"><span class="direction"><?php echo JText::_('JPREV'); ?></span> <span class="title"><?php echo $row->prev->title; ?></span></a>
	</li>
<?php endif; ?>
<?php if ($row->next->link && $row->next->title) : ?>
	<li class="next">
		<a href="<?php echo $row->next->link; ?>" rel="next"><span class="direction"><?php echo JText::_('JNEXT'); ?></span> <span class="title"><?php echo $row->next->title; ?></span></a>
	</li>
<?php endif; ?>
</ul>
