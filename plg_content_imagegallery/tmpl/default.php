<?php
defined('_JEXEC') or die;
?>
<div id="<?php echo $id; ?>" class="carousel slide">
	<div class="carousel-inner">
		<?php foreach($images as $key => $image) : ?>
			<?php if(!empty($image->filename) && !empty($image->alt)) : ?>
				<div class="item itemid-<?php echo $key; if($key == 0) : ?> active<?php endif; ?>">
					<div class="carousel-image">
						<img src="<?php echo $image->filename; ?>" alt="<?php echo $image->alt; ?>" />
					</div>
					<?php if(!empty($image->title) || !empty($image->description)) : ?>
						<div class="carousel-caption">
							<?php if (!empty($image->title)) : ?>
								<h4><?php echo $image->title; ?></h4>
							<?php endif; ?>
							<?php if (!empty($image->description)) : ?>
								<p><?php echo $image->description; ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<a class="left carousel-control" href="#<?php echo $id; ?>" data-slide="prev">&lsaquo;</a>
	<a class="right carousel-control" href="#<?php echo $id; ?>" data-slide="next">&rsaquo;</a>
</div>
