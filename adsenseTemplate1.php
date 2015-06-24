<?php
	 add_filter( 'the_content', 'at1_add_adsense_below_title' ); 
	 add_filter( 'the_content', 'at1_add_adsense_below_content', 30 ); 
	get_header();
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

					// Previous/next post navigation.
					//twentyfourteen_post_nav();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php
	get_sidebar();
	get_footer();
	
	function at1_add_adsense_below_title($content){
		$top_ad = adsense_template_get_option( 'top_ad' );
		$ad = '<div style="float:right;margin-left:20px;margin-right:20px;margin-bottom:20px">'.$top_ad.'</div>';
		$content = $ad . $content;
		return $content;
	}
	
	function at1_add_adsense_below_content($content){
		$bottom_ad = adsense_template_get_option( 'bottom_ad' );
		$ad = '<div style="text-align:center;margin-top:20px;margin-bottom:20px">'.$bottom_ad.'</div>';
		$content =  $content . $ad;
		return $content;
	}


?>