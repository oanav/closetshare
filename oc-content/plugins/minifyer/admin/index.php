<?php
$plugin_data = Plugins::getInfo('minifyer/index.php');
?>
<style>
    #minifyer {
        position: relative;
        width: 70%;
    }
    #minifyer hr {
        border: 0;
        border-top: 1px solid #dfdfdf;
        margin-bottom: 20px;
        margin-top: 10px;
    }
    #minifyer h2.title {
        padding-left: 170px;
        background: #efefef;
        margin: 0;
        padding-top: 20px;
        padding-bottom: 20px;
        color: #555;
        margin-top: -20px;
    }
    #minifyer h2 * {
        display: inline-block;
        line-height: 62px;
        font-size: 14px;
        vertical-align: middle;
    }
    #minifyer #tabs {
        float: left;
        width: 100%;
    }
    #minifyer .current_logo {
        width: 350px;
        padding: 20px;
        border: 1px solid #efefef;
    }
    #minifyer .form-row {
        padding-top: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #efefef;
    }
    #minifyer .form-row.last {
        border-bottom: none;
    }
    #minifyer .help-text {
        color: #999;
        font-size: 12px;
        margin-top: 0;
        margin-bottom: 0;
    }
    #minifyer code {
        border: none;
        padding: 0;
        background: transparent;
    }
</style>
<div id="minifyer" class="plugin-configuration form-horizontal">
    <form id="plugin-frm" action="<?php echo osc_admin_base_url(true); ?>" enctype="multipart/form-data" method="post">
        <input type="hidden" name="page" value="plugins" />
        <input type="hidden" name="action" value="configure_post" />
        <input type="hidden" name="plugin" value="minifyer/index.php" />
        <input type="hidden" name="plugin_short_name" value="<?php echo $plugin_data['short_name']; ?>" />
        <fieldset>
            <div class="header">
                <h2 class="render-title">
                    <img src="<?php echo osc_plugin_url('minifyer/admin/assets/img').'img/logo.png'; ?>" width="240"/>
                    <small><?php echo $plugin_data['description']; ?></small>
                </h2>
            </div>
            <br clear="all"/>
            <div>
                <div id="tabs">
                    <ul>
                        <li><a href="#tab-default"><?php _e('About','minify')?></a></li>
                        <li><a href="#tab-help"><?php _e('Need help?','minifyer'); ?></a></li>
                        <li><a href="#tab-changelog"><?php _e('Changelog','minifyer'); ?></a></li>
                    </ul>

                    <div id="tab-default" class="tab" style="float: left; width: 97%">
                        <div class="form-horizontal">

                            <h1><?php _e('Load you ad\'s site faster than ever before!','minify')?></h1>
                            <p><?php _e('This plugin is a wrapper for the php Minify library created by <a target="_blak" href="https://github.com/mrclay">Steve Clay</a>.','minify')?></p>

                            <div class="form-row">

                            <h2 style="color: #d82525;"><?php _e('What it does?','minify')?></h2>
                            <p><?php _e('It compresses sources of content
(usually files), combines the result and serves it with appropriate
HTTP headers. These headers can allow clients to perform conditional
GETs (serving content only when clients do not have a valid cache)
and tell clients to cache the file for a period of time.','minify')?></p>
                            </div>
                            <div class="form-row">

                            <h2 style="color: #d82525;"><?php _e('How to use it','minify')?></h2>
                            <p> <?php _e('In order for this plugin to do it\'s job, the scripts need to be in the
			queue to be loaded, that means your theme has to register and queue your
			scripts and styles the right way ( obs: styles don\'t need to be registered ).','minify');?></p>

                            </div>

                            <h2 style="color: #d82525;"><?php _e('But how to properly enqueue css and js files on my theme?','minify');?></h2>
                            <p><?php _e('The OsClass plataform has two great functions, to help you register and render your css and js files, no matter if you are making a theme or a plugin, the Minifyer plugin optimizes it all if enqueued.','minify');?></p>

                            <div class="form-row">
                                <h4><?php _e('To enqueue your theme css files:','minify');?></h4>
                                <pre class="line-numbers"><code class="language-php">osc_enqueue_style('your-style-id', osc_current_web_theme_url('css/your-css-filename.css') );</code></pre>
                                <h4><?php _e('To enqueue your plugin css files:','minify');?></h4>
                                <pre class="line-numbers"><code class="language-php">osc_enqueue_style('your-style-id', osc_plugin_url('your-plugin-name/css').'css/your-css-filename.css' );</code></pre>

                                <h4><?php _e('To enqueue your theme js files first you have to register each script:','minify');?></h4>
                                <pre class="line-numbers"><code class="language-php">osc_register_script( 'your-script-id', osc_current_web_theme_url('js/your-js-filename.js') );</code></pre>

                                <h4><?php _e('Than enqueue it:','minify');?></h4>
                                <pre class="line-numbers"><code class="language-php">osc_enqueue_script('your-script-id');</code></pre>

                                <h4><?php _e('The same is done for plugin js files, just change the url of the script:','minify');?></h4>
                                <pre class="line-numbers"><code class="language-php">osc_register_script( 'your-script-id', osc_plugin_url('your-plugin-name/js').'js/your-js-filename.js' );</code></pre>

                                <h4><?php _e('Than enqueue it:','minify');?></h4>
                                <pre class="line-numbers"><code class="language-php">osc_enqueue_script('your-script-id');</code></pre>
                             </div>

                            <p>&nbsp;</p>


                            <h2 style="color: #d82525;"><?php _e('Like Minifyer?','minify')?></h2>
                            <p><?php _e('If my Minifyer plugin has been useful to you and your business, please consider donating, any amount will contribute for the development of more great plugins that can help you sky rocket your project!','minify')?></p>
                            <div class="form-row">
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="BDUJ8SAAMGKAS">
                                    <input type="image" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - A maneira mais f�cil e segura de efetuar pagamentos online!">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/en/i/scr/pixel.gif" width="1" height="1">
                                </form>
                            </div>

                        </div>
                    </div>

                    <div id="tab-help">
                        <div class="description">
                            <h3><a href="http://layoutzweb.freshdesk.com/support/home" target="_blank">Visit our support site</a></h3>
                        </div>
                    </div>

                    <div id="tab-changelog">
                        <div class="description">
                            <h2>Changelog</h2>
                            <h3>2.0.0 - Release!</h3>
                            <h3>2.0.1 - Php code improvements</h3>

                            <hr>

                            <h2>Future changes</h2>
                            <ol>
                                <li>Html compression and cache</li>
                            </ol>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<p>&nbsp;</p>
<hr>
<p>&nbsp;</p>

<?php require osc_plugin_path('minifyer/admin/parts/lz_related_products.php'); ?>
<script>
    $(document).ready(function(){
        var tabs = $( "#tabs" ).tabs();
    });
</script>