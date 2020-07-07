<?php
class Submenu_Page {
    public function render() {
        // Get all widget registered
        global $wp_registered_sidebars;
        $sidebars = $wp_registered_sidebars;
        if (isset($_GET['status'])){
            if ($_GET['status'] == 'success'){
                do_action('drf_success');
            }
            if ($_GET['status'] == 'error'){
                do_action('drf_error');
            }
        }
        ?>
        <div class="wrap">
            <h2><?php _e( "Rewrite all footers from template the7" , "davidev-rewrite-footer" ); ?></h2>
            <p><?php _e( "Before confirming this procedure, I recommend <b> make a backup of the entire database </b>" , "davidev-rewrite-footer" ); ?></p>
            <form action="<?php echo admin_url( 'admin-post.php' ) ?>" method="post">
                <input type="hidden" name="action" value="process_rewrite_footer_the7">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th><?php _e( "Select typology list" , "davidev-rewrite-footer" ); ?></th>
                        <td>
                            <select name="type" id="type">
                                <option value="post"><?php _e( "Posts" , "davidev-rewrite-footer" ); ?></option>
                                <option value="page"><?php _e( "Pages" , "davidev-rewrite-footer" ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e( "Select widgetarea" , "davidev-rewrite-footer" ); ?></th>
                        <td>
                            <select name="widgetarea_id" id="widgetarea_id">
                                <?php foreach ($sidebars as $side_element){?>
                                    <option value="<?php echo $side_element['id'];?>"><?php echo $side_element['name'];?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                    <table>
                        <?php wp_nonce_field(); ?>
                    <p><?php @submit_button(); ?></p>
            </form>
        </div>
        <?php
    }
}