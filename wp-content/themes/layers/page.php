<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="main">
    <!--Begin main -->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" class="xfolkentry">
	<h2><a href="<?php the_permalink() ?>" class="taggedlink entry-title" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	<div class="date"><abbr class="published updated" title="<?php the_time('Y-m-d\TH:i:s\Z'); ?>"><?php the_time('F jS, Y') ?></abbr></div>
    <span class="vcard author">by<span class="fn"> <?php the_author() ?></span></span>
		<div class="description">
        <?php the_content('Read the rest of this entry &raquo;'); ?>
<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
        </div><!-- End description -->  
		<?php if ('open' == $post->comment_status) : ?>
          
        <!--comments are open -->
        <p class="details"><a href="<?php comments_link(); ?>">Comments (<?php comments_number('0','1','%'); ?>)</a><?php edit_post_link('Edit', ' | ', ''); ?></p>
        <?php else: ?>
        <!--comments are closed -->
        <?php /*check to see if there are any comments*/
            
            if ($comments) : ?>
            <p class="details"><a href="<?php comments_link(); ?>">Comments (<?php comments_number('0','1','%'); ?>)</a><?php edit_post_link('Edit', ' | ', ''); ?></p>
            <?php else: /* Any detail should not be shown because no comments and comments are closed*/?>
            <!-- <p class="details"><a href="<?php comments_link(); ?>">Comments (<?php comments_number('0','1','%'); ?>)</a><?php edit_post_link('Edit', ' | ', ''); ?></p> -->
            <?php endif; ?>
        <?php endif; ?>
            
<?php comments_template(); ?>
      </div><!-- div post-<?php the_ID(); ?> ends here --> 
<?php endwhile; else : ?>

		<h1>Not Found</h1>
		<p>We respect your curiosity! But, what you are looking is not present here. Don't be disappointed, keep the spirit spirits high, keep learning, keep finding! Curiosity is good, first step towards innovation.</p>

	<?php endif; ?>

</div><!--End main -->
</div><!-- End center -->
</div><!--End primary-->

<?php get_footer(); ?>