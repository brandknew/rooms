<?php global $form_id; ?>
<form name="searchform<?php echo $form_id;?>" role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <input type="search" class="search-field text-field" placeholder="SEARCH" value="" name="s" title="Search for:" />
    <span class="rooms-icon-search search-submit" onclick="searchform<?php echo $form_id;?>.submit()"></span>
</form>