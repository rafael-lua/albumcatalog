
<div class="searchresults">

<h3>Resultados (<?php echo count($albuns) ?>): </h3>

<?php if(is_array($albuns) && !empty($albuns)) : ?>

	<?php foreach($albuns as $album) : ?>
	
		<a href="<?php echo base_url(); ?>/albums/showalbum/<?php echo esc($album["id"]); ?>">
		<p style="padding:10px"><?php echo esc($album["name"])." - ".esc($album["year"]); ?></p>
		</a>
		
	<?php endforeach; ?>

<?php endif; ?>

</div>
