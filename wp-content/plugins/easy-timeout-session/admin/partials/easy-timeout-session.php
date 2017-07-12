<?php

/**
 * The Easy Timeout Session is a plugin that allows you to change the
 * session timeout for a wordpress user. This particular file is
 * responsible for including the dependencies and starting the plugin.
 *
 * @package ETS
 */

?>
<style>
    .easy-wysiwyg-style-head {
        color: #cdbfe3;
        text-shadow: 0 1px 0 rgba(0,0,0,.1);
        background-color: #6f5499;
    }
    .easy-wysiwyg-style-head h1 {
        color: #ffffff !important;
        font-family: HelveticaNeue, 'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif;
    }
    .about-wrap .wp-badge {
        right: 15px;
        background-color: transparent;
        box-shadow: none;
    }
    .about-text {
        color: #cdbfe3 !important;
    }


    .easy-more {
        margin-top: 15px;
        background: #FFFFFF;
        border: 1px solid #E5E5E5;
        position: relative;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
        padding: 5px 15px;
    }
    .easy-plugins-box {
        background-color: #EEEFFF;
        border: 1px solid #E5E5E5;
        border-top: 0 none;
        position: relative;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
        padding: 15px;
    }
    .easy-bottom {
        background-color: #52ACCC;
        color: #FFFFFF;
        border: 1px solid #FFFFFF;
        border-top: 0 none;
        position: relative;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
        padding: 5px 15px;
    }
    .easy-bottom a {
        color: #FFFFFF;
    }
    .border {
        border: 1px solid #E5E5E5;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
        padding: 20px;
    }
    .nopadding {
        padding-right: 0px !important;
    }
    #wpcontent {
        background-color: #ffffff;
    }
</style>
<div class="wrap about-wrap">
    <div class="row easy-wysiwyg-style-head">
        <div class="col-md-12 ">
            <h1>Easy Timeout Session</h1>
            <div class="about-text">Thank you for installing Easy Login Form! This WordPress plugin makes
                it even easier to customize your site.</div>
            <div class="wp-badge">ETS v1.1</div>
        </div>
    </div>
    <hr/>

    <div class="row">
        <div class="col-md-9">
            <div>
                <h3>Easy Timeout Session Configuration</h3>
                <p>To configure this plugin is easy, just specify the duration of the session.</p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="img-rounded border">
                        <form method="post" action="options.php" enctype="multipart/form-data">
                            <?php settings_fields( 'cts' ); ?>
                            <?php do_settings_sections( 'cts' ); ?>
                            <?php $cts=get_option('cts'); if (!is_array($cts)){ $cts = array(); $cts['num']=''; $cts['val']=''; } ?>
                            <p><strong>minimum:</strong> 5 min | <strong>by default:</strong> 2 days</p>
                            <input type="text" name="cts[num]" id="cts[num]" value="<?= $cts['num']; ?>" maxlength="7" style="width:75px"/>
                            <input type="radio" name="cts[val]" id="minutes" value="minutes" <?= ($cts['val'] == "minutes" ? "checked" : "") ?>/> <label for="minutes">Minutes</label>
                            <input type="radio" name="cts[val]" id="hours" value="hours" <?= ($cts['val'] == "hours" ? "checked" : "") ?>/> <label for="hours">Hours</label>
                            <input type="radio" name="cts[val]" id="days" value="days" <?= ($cts['val'] == "days" ? "checked" : "") ?>/> <label for="days">Days</label>
                            <?php submit_button(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 nopadding">
            <div class="easy-more">
                <h4>Related plugins:</h4>
                <ul>
                    <li>
                        <a href="https://wordpress.org/plugins/easy-admin-menu/" target="_blank">· Easy Admin Menu</a>
                    </li>
                    <li>
                        <a href="https://wordpress.org/plugins/easy-login-form/" target="_blank">· Easy Login Form</a>
                    </li>
                    <li>
                        <a href="https://wordpress.org/plugins/easy-options-page/" target="_blank">· Easy Options Page</a>
                    </li>
                    <li>
                        <a href="https://wordpress.org/plugins/easy-timeout-session/" target="_blank">· Easy Timeout Session</a>
                    </li>
                    <li>
                        <a href="https://wordpress.org/plugins/easy-wysiwyg-style/" target="_blank">· Easy Wysiwyg Style</a>
                    </li>
                </ul>
            </div>
            <div class="easy-plugins-box">
                <!--                <h2>Easy Wysiwyg Style</h2>-->
                <div class="text-center">
                    <p>This plugin is Free Software and is made available free of charge.</p>
                    <p>If you like the software, please consider a donation.</p>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" class="">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="CHXF6Q9T3YLQU">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>
            </div>
            <div class="easy-bottom">
                Created by <a href="http://jokiruiz.com" target="_blank">Joaquín Ruiz</a>
            </div>
        </div>
    </div>
</div>
