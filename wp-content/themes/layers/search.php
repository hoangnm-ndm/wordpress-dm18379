<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="main">
    <!--Begin main -->

<?php if (have_posts()) : ?>

<h2>Search Results</h2>

<p>You searched for "<?php the_search_query() ?>". Here are the results:</p>

		<?php while (have_posts()) : the_post(); ?>

	<h2><a href="<?php the_permalink() ?>" class="taggedlink entry-title" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	<div class="date"><abbr class="published updated" title="<?php the_time('Y-m-d\TH:i:s\Z'); ?>"><?php the_time('F jS, Y') ?></abbr></div>
    <span class="vcard author">by<span class="fn"> <?php the_author() ?></span></span>


		<p class="details"><?php the_tags('Tags: ', ', ', '<br />'); ?>Posted in <?php the_category(', ') ?> | <a href="<?php comments_link(); ?>">Comments (<?php comments_number('0','1','%'); ?>)</a><?php edit_post_link('Edit', ' | ', ''); ?></p>

<?php endwhile; ?>


<div class="float-left"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="float-right"><?php previous_posts_link('Newer Entries &raquo;') ?></div>


	<?php else : ?>

		<h1>Not Found</h1>
		<p>We respect your curiosity! But, what you are looking is not present here. Don't be disappointed, keep the spirit high, keep learning, keep finding! Curiosity is good, first step towards innovation.</p>

	<?php endif; ?>

</div><!--End main -->
</div><!-- End center -->
</div><!--End primary-->

<?php get_footer(); ?>