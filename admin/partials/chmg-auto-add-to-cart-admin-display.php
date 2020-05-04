<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/admin/partials
 */

    require_once plugin_dir_path( __FILE__ ).'../../utils/db-utils.php';
    require_once plugin_dir_path( __FILE__ ).'../../utils/data-utils.php';


    if($_POST['submit'] ){
        require_once plugin_dir_path( __FILE__ ).'../post-processors/save.php';
    }elseif($_POST['delete']){
        require_once plugin_dir_path( __FILE__ ).'../post-processors/delete.php';
    }else if($_POST['update_status']){
        require_once plugin_dir_path( __FILE__ ).'../post-processors/update.php';  
    }else if($_POST['edit_rule']){
        require_once plugin_dir_path( __FILE__ ).'../post-processors/edit-rule.php';  
    }

    $query_params = $_GET['product-id'];
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<section class="aatc-main"> 

    <div class="aatc-left-bar">
        <div class="section-title">
            <h2 > BOGOF Rule </h2>
            <h4>Create a rule to automatically add a product to cart when the rule matches</h4>
            <?php if($query_params): ?>
                <a class="create-new-rule" href="/wp-admin/edit.php?post_type=product&page=auto-add-to-cart-page">Create New Rule</a>
            <?php endif; ?>
        </div>

      <?php if(!$query_params): ?>
       <!-- Create Form  -->
      <?php require_once plugin_dir_path( __FILE__ ).'../forms/create.php' ?>
      <?php else: ?>
       <!-- Edit Form -->
       <?php require_once plugin_dir_path( __FILE__ ).'../forms/edit.php' ?>
      <?php endif;?>

    </div>

    <div class="aatc-right-bar">
        <table id="aatc_list" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IF THIS</th>
                    <th>THEN ADD</th>
                    <th>Criteria</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Qty</th>
                    <th>Coupon Code</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

            <?php 
                $count; 
                foreach(CPLC_DB_Utils::Fetch_aatc_data() as $record): 
                $startDate = $record->start_date != '0000-00-00' ? date_format(DateTime::createFromFormat('Y-m-d', $record->start_date),"jS F, Y") : $record->start_date ;
                $endDate = $record->end_date != '0000-00-00' ? date_format(DateTime::createFromFormat('Y-m-d', $record->end_date),"jS F, Y") : $record->end_date ;
            ?>


                <tr>
                    <td><?php echo ++$count; ?></td>
                    <?php if($record->type === 'products'): ?>
                        <td><?php echo CPLC_DB_Utils::product_name($record->source_ids);  ?></td>
                    <?php else: ?>
                        <td><?php echo CPLC_DB_Utils::get_product_category_by_id($record->source_ids);  ?></td>
                    <?php endif; ?>
                   
                    
                    <?php if(strpos($record->target_ids, ",") !== false): ?>
                    <?php
                        $product_id_arrays = uncompress_array($record->target_ids);
                    ?>
                       <td>
                           <?php foreach($product_id_arrays as $product_id): ?>
                             <p><?php echo CPLC_DB_Utils::product_name($product_id);  ?></p>
                           <?php endforeach; ?>
                       </td>
                    <?php else: ?>
                       <td><?php echo CPLC_DB_Utils::product_name($record->target_ids);  ?></td>
                    <?php endif; ?>

                    <td><?php echo $record->type; ?></td>
                    <td><?php  echo  $startDate ; ?></td>
                    <td><?php echo $endDate; ?></td>
                    <td><?php echo $record->quantity; ?></td>
                    <td><?php echo $record->coupon_code; ?></td>
                    <td>
                         <?php if('active' === $record->status): ?>
                            <form method="post" name="auto_add_form" action="">
                                <input type="hidden" name="product_id" value="<?php esc_attr_e($record->id); ?>"/>
                                <input type="hidden" name="status" value="inactive"/>
                                <?php submit_button('Disable', 'secondary deactivate aatc_button','update_status', TRUE); ?>
                            </form>  
                         <?php else: ?>
                            <form method="post" name="auto_add_form" action="">
                                <input type="hidden" name="status" value="active"/>
                                <input type="hidden" name="product_id" value="<?php esc_attr_e($record->id); ?>"/>
                                <?php submit_button('Enable', 'secondary activate aatc_button','update_status', TRUE); ?>
                            </form> 
                         <?php endif; ?>
                    </td>
                  
                    <td>
                        <p class="submit">
                            <a href="/wp-admin/edit.php?post_type=product&page=auto-add-to-cart-page&product-id=<?php echo $record->id; ?>" class="aatc-edit-rule">Edit</a>
                        </p>
                    </td>
                    <td>
                    <form method="post" name="auto_add_form" action="">
                        <input type="hidden" name="product_id" value="<?php esc_attr_e($record->id); ?>"/>
                        <?php submit_button('Delete', 'secondary aatc_button','delete', TRUE); ?>
 					</form>    
                 </td>
                </tr> 
                 
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</section>
