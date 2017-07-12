<?php get_template_part( 'templates/head' ); ?>
<?php $rtl = skilled_get_option( 'is-rtl', false ); ?>
<body <?php body_class(); ?><?php if ($rtl): ?> dir="<?php echo esc_attr('rtl'); ?>"<?php endif; ?>>
	<div class="cbp-row wh-top-bar">
		<div class="cbp-container">
			<div class="one whole wh-padding wh-top-bar-text align-right">
				<div class="wh-logo-wrap one fourth wh-padding home-pad">
				<div class="wh-logo align-left"><a style="margin-left: -15px;" href="<?php echo site_url(); ?>">
				<img src="<?php echo site_url(); ?>/wp-content/uploads/2016/11/business_Logo.png" alt="logo" />
				</a></div>
				</div>
				<div class="three fourths wh-padding wh-top-bar-additional-text align-left">
                  <span class="scp-icon scp-icon-background pull-right" style="margin: 0 0px 0 8px;text-align:center;">
                     <form class="search-form form-inline" action="<?php echo site_url(); ?>/" method="get"><input class="search-field" name="s" value="" placeholder="Search " type="search">
                        <img class="search-icon" src="<?php echo site_url(); ?>/wp-content/uploads/2016/12/search-top.png">
                        <label class="hidden">Search for:</label>
                     </form>
                  </span>
                  <span class="scp-icon scp-icon-background pull-right" style="margin:0 8px;text-align:center;"><a href="https://www.instagram.com/abcschoolofenglish" target="_blank">
                  <i class="fa fa-instagram" style="color:#666;font-size:20px;line-height:46px;" onmouseover="this.style.color='#666'" onmouseout="this.style.color='#666'"></i></a>
                  </span>
                  <span class="scp-icon scp-icon-background pull-right" style="margin:0 8px;text-align:center;"><a href="https://www.facebook.com/ABC.School.of.English/" target="_blank">
                  <i class="Defaults-facebook facebook-f" style="color:#666;font-size:20px;line-height:46px;" onmouseover="this.style.color='#666'" onmouseout="this.style.color='#666'"></i></a>
                  </span>
                  <span class="scp-icon scp-icon-background pull-right" style="margin:0 8px 0 25px;text-align:center;"><a href="https://twitter.com/ABC_Sch_English" target="_blank">
                  <i class="Defaults-twitter" style="color:#666;font-size:20px;line-height:46px;" onmouseover="this.style.color='#666'" onmouseout="this.style.color='#666'"></i></a>
                  </span>
                  <div class="scp-shortcode scp-icon-bullet-text pull-right lang-margin" style="padding: 0px;">
                     <div class="align-center scp-icon-bullet-text-icon" style="color: #666; font-size: 32px;"><img src="<?php echo site_url(); ?>/wp-content/uploads/2016/12/earth.png"></div>
                     <div class="scp-icon-bullet-text-text pad-left" style="margin: -5px 0px 0px 0px;">
                        <p class="title lang" style="color: #24719c;">English</p>
<?php                        
wp_nav_menu( array( 'theme_location' => 'language-menu', 'menu_class' => 'sf-menu wh-menu-main pull-right') );
?>
                     </div>
                  </div>
                  <div class="scp-shortcode scp-icon-bullet-text pull-right phone-margin" style="padding: 0px;">
                     <div class="align-center scp-icon-bullet-text-icon" style="color: #666; font-size: 32px;"><img src="<?php echo site_url(); ?>/wp-content/uploads/2016/12/phone.jpg"></div>
                     <div class="scp-icon-bullet-text-text pad-left" style="margin: -5px 11px 0px 0px;">
                        <p class="title phone" style="color: #24719c;">+44 (0) 20 7836 8999</p>
                        <p class="description" style="color: #666; font-size: 14px; margin-top: 3px;">Call us</p>
                     </div>
                  </div>
               </div>
			</div>
		</div>
	</div>

<?php get_template_part( 'templates/header' );?>

    <?php 
//        global $woocommerce;
//        $items = $woocommerce->cart->get_cart();
//        print_r($items);
    ?>