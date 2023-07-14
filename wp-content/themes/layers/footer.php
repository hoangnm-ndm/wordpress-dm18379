<div id="secondary"
                 class="clear">
                <!-- Begin secondary -->

                <div class="center">

                    <!--center-->

                    <div id="secondaryContent">
                        <!-- Begin secondaryContent -->

	
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
	                    <div class="block">
                        <ul>
                        <li>
	                        <h3><a href="#">Recent Posts</a></h3>
	                            <ul>
	                                <?php wp_get_archives('title_li=&type=postbypost&limit=5'); ?>
	                            </ul>
                        </li>
                        </ul>
                        </div>
                        <div class="block">
                        <ul>
                        <li>
	                        <h3>Monthly</h3>
	                        <ul>
	                            <?php wp_get_archives('title_li=&type=monthly&limit=5'); ?>
	                        </ul>
                        </li>
                        </ul>
                        </div>
                        <div class="block">
                        <ul>
                        <li>
	                        <h3>Meta</h3>
	                        <ul>
	                        <?php wp_register(); ?>

				                <li><?php wp_loginout(); ?></li>

				                <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>

				                <li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>

				                <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>

				            <?php wp_meta(); ?>
	                        </ul>
                        </li>
                        </ul>
                        </div>
                <?php endif; ?>
                </div><!--End secondaryContent -->
             </div><!--End center -->
         </div><!-- End secondary -->
     </div><!-- End content -->

     <div id="footer" class="clear">

            <!-- Begin footer -->

            <div class="center">
                <p>
                   
                                     
                   <a href="http://www.wordpress.org" title="Wordpress website">Wordpress</a> powers
                   <span class="copyAuthor" > <?php bloginfo('name'); ?></span>. <a href="http://jaipandya.com/themes/" title="Theme URI">Layers</a> theme Designed by 
                   <span class="vcard"><a class="fn n" title="Layers author URI" href="http://jaipandya.com">Jai Pandya</a>.</span>
                   
                 </p>  
                   
                   
                   
                   
            </div>
        </div><!-- End footer -->
        </div><!-- End wrapper -->
        <?php wp_footer() ?>

    </body>
</html>
