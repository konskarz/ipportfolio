<?php
defined('_JEXEC') or die;
?>
<div id="<?php echo $id; ?>" class="carousel slide carousel-fade">
	<div class="carousel-inner wide767">
		<?php foreach($images as $key => $image) : ?>
			<?php if(!empty($image->filename) && !empty($image->alt)) : ?>
				<div class="item itemid-<?php echo $key; if($key == 0) : ?> active<?php endif; ?>">
					<div class="carousel-image">
						<img src="<?php echo $image->filename; ?>" alt="<?php echo $image->alt; ?>" />
					</div>
					<?php if(!empty($image->title)) : ?>
						<div class="carousel-caption">
							<p><?php echo $image->title; ?></p>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<div class="carousel-controls">
		<a href="#<?php echo $id; ?>" data-slide="prev">previous</a>
		<a href="#<?php echo $id; ?>" data-slide="next">next</a>
	</div>
</div>
