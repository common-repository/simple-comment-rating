<?php ?>

<div class="wrap">
    <div id="icon-themes" class="icon32"><br></div>
    <h2><?php echo __("Simple Comment Rating Options", ConstantsSCR::TEXT_DOMAIN); ?></h2>

    <?php settings_errors(); ?>
    
    <form method="post" action="options.php">
        <?php settings_fields('scr_settings'); ?>  
        <?php do_settings_sections('scr_settings'); ?>             
        <?php submit_button(); ?>  
    </form>
</div>