<div id="postbox">
    <form id="new_post" name="new_post" method="post">

    <p><label for="title">Title</label><br />
        <input type="text" id="title" value="" tabindex="1" size="20" name="title" />
    </p>

    <p>
        <label for="content">Post Content</label><br />
        <textarea id="content" tabindex="3" name="content" cols="50" rows="6"></textarea>
    </p>

    <p><?php wp_dropdown_categories( 'show_option_none=Category&tab_index=4&taxonomy=category' ); ?></p>

    <p><label for="post_tags">Tags</label>

    <input type="text" value="" tabindex="5" size="16" name="post_tags" id="post_tags" /></p>

    <?php wp_nonce_field( 'wps-frontend-post' ); ?>

    <p align="right"><input type="submit" value="Publish" tabindex="6" id="submit" name="submit" /></p>
    
    </form>
</div>