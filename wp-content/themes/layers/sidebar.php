<div id="content">

            <!-- Begin content -->

            <div id="primary">
                <!-- Begin primary -->

                <div class="center">
                    <!-- Begin center -->

                    <div id="sidebar">
                        <!-- Begin sidebar -->

                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Sidebar") ) : ?>
                        <h3>Categories</h3>
	                    <ul>
                        <?php wp_list_categories('title_li'); ?>
	                    </ul>

                        <?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>&category_before=&category_after='); ?>

                        <h3>Search</h3>

                        <?php get_search_form(); ?>

                        <?php endif; ?>

                    </div>
                        <!--End sidebar -->
