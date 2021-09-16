<?php
/**
*
* @package Cariera
*
* @since    1.0.0
* @version  1.5.3
* 
* ========================
* STANDARD POST FORMAT
* ========================
*     
**/



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>


<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>    
    <?php cariera_post_thumb( [ 'size' => 'full', 'class' => 'post-image' ] ); ?>
    
    <div class="blog-desc">
        <h3 class="blog-post-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
        
        <?php echo cariera_posted_meta(); ?>
        
        <div class="blog-post-exerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <a href="<?php the_permalink(); ?>" class="btn btn-main btn-effect mt20">
            <?php esc_html_e('Read More','cariera') ?>
        </a>
    </div>
</article>