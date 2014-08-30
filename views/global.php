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
</div>