<article <?php post_class('bt-post'); ?>>
	<?php
		echo influencers_post_featured_render('full');
		echo influencers_post_publish_render();
		if(is_single()){
      echo influencers_single_post_title_render();
		}else{
      echo influencers_post_title_render();
		}
		echo influencers_post_meta_render();
		echo influencers_post_content_render();
	?>
</article>
