<div id='global'>
	<ul class="">
		<?php foreach ($menus as $site => $url): ?>
			<li>
				<a href="<?php echo $url ?>">
					<?php echo $site ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>
	<?php if ($social['enabled']): ?>
		<div class="social">
			<?php foreach($social['profiles'] as $profile => $url): if(empty($url)) continue; ?>
				<a href="<?php echo $url ?>" class="icon">
					<img src="<?php echo $presenter::url("images/$profile.png") ?>">
				</a>
			<?php endforeach ?>
		</div>		
	<?php endif ?>

</div>