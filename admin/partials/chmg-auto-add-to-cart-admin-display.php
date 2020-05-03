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
    }

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<section class="aatc-main"> 

    <div class="aatc-left-bar">
        <div class="section-title">
            <h2 >Create Auto ADD Rule </h2>
            <small>Lorem ipsum dolor sit amet consectetur adipisicing elit. </small>
        </div>

        <form action="" name='submit' method="post" id="aatc-form">

        <div class="form-group">
            <label for="criteria">Criteria</label>
            <select data-placeholder="Choose categories..." class="chosen-select" id="criteria" name="criteria">
                <option value="products">Products</option>
                <option value="categories">Categories</option>
            </select>
        </div>

        <fieldset>
            <legend>IF SELECTED:</legend>

            <div class="form-group categories">
                <label for="categories">Categories</label>
                <select   data-placeholder="Choose categories..." class="chosen-select" id="categories" name="categories">
                    <option value="">Select Categories</option>
                    <?php foreach(CPLC_DB_Utils::get_all_product_categories() as $cat): ?> 
                        <option value="<?php echo $cat->term_id; ?>">
                        <?php echo "(#".$cat->term_id.") ".$cat->name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group products">
                <label for="products">Products</label>
                <select   data-placeholder="Choose Product..." class="chosen-select" name="products" id="products">
                    <option value="">Select Product</option>
                    <?php foreach(CPLC_DB_Utils::get_products() as $product_id): ?>

                    <?php $product = wc_get_product( $product_id ); ?>
                        <?php if ($product->is_type( 'variable' )): ?>
                                <optgroup label="<?php echo $product->get_name(); ?>">
                                <?php
                                        $variations = CPLC_DB_Utils::get_products_variations($product_id);
                                ?>

                                <?php foreach($variations as $product_id): ?>
                                    <?php

                                        $product = wc_get_product( $product_id );
                                        $variation_product_name = $product->get_name();
                                        $variation_product_regular_price = $product->get_regular_price();
                                        $variation_product_sales_price = $product->get_sale_price();

                                        if(!empty($variation_product_sales_price)){
                                            $variation_product_price = $variation_product_sales_price;
                                        }else{
                                            $variation_product_price = $variation_product_regular_price;
                                        }
                                    ?>
                                    <option value="<?php echo $product_id; ?>"><?php echo "(#".$product_id.") ".$variation_product_name; ?></option>
                                <?php endforeach;?>

                            </optgroup>
                        <?php else: ?>
                                <?php
                                    $product_name = $product->get_name();
                                    $product_id = $product->get_ID();
                                    $product_regular_price = $product->get_regular_price();
                                    $product_sales_price = $product->get_sale_price();

                                    if(!empty($product_sales_price)){
                                        $product_price = $product_sales_price;
                                    }else{
                                        $product_price = $product_regular_price;
                                    }

                                ?>
                                <option value="<?php echo $product_id; ?>"><?php echo "(#".$product_id.") ".$product_name; ?></option>

                        <?php endif; ?>
                    <?php endforeach;?>
                </select>
            </div>

       </fieldset>

        <fieldset>
            <legend>Also Add this to cart:</legend>
            <div class="form-group">
            <label for="auto_add_product">Products</label>
            <select   data-placeholder="Choose categories..." class="chosen-select" name="auto_add_product[]" id="auto_add_product" multiple>

                <option value="">select product</option>
                <?php foreach(CPLC_DB_Utils::get_products() as $product_id): ?>

                <?php $product = wc_get_product( $product_id ); ?>
                    <?php if ($product->is_type( 'variable' )): ?>
                            <optgroup label="<?php echo $product->get_name(); ?>">
                            <?php
                                    $variations = CPLC_DB_Utils::get_products_variations($product_id);
                            ?>

                            <?php foreach($variations as $product_id): ?>
                                <?php

                                    $product = wc_get_product( $product_id );
                                    $variation_product_name = $product->get_name();
                                    $variation_product_regular_price = $product->get_regular_price();
                                    $variation_product_sales_price = $product->get_sale_price();

                                    if(!empty($variation_product_sales_price)){
                                        $variation_product_price = $variation_product_sales_price;
                                    }else{
                                        $variation_product_price = $variation_product_regular_price;
                                    }
                                ?>
                                <option value="<?php echo $product_id; ?>"><?php echo "(#".$product_id.") ".$variation_product_name; ?></option>
                            <?php endforeach;?>

                        </optgroup>
                    <?php else: ?>
                            <?php
                                $product_name = $product->get_name();
                                $product_id = $product->get_ID();
                                $product_regular_price = $product->get_regular_price();
                                $product_sales_price = $product->get_sale_price();

                                if(!empty($product_sales_price)){
                                    $product_price = $product_sales_price;
                                }else{
                                    $product_price = $product_regular_price;
                                }

                            ?>
                            <option value="<?php echo $product_id; ?>"><?php echo "(#".$product_id.") ".$product_name; ?></option>
            
                    <?php endif; ?>
            <?php endforeach;?>
        </select>
        </div>
        </fieldset>

        <fieldset>
            <legend>Schedule</legend>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date">
            </div> 
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date">
            </div> 
        </fieldset>
    
        <div class="form-group">
            <?php submit_button('Save Changes', ' primary aatc_button','submit', TRUE); ?>
        </div>     
      
        </form> 
    </div>

    <div class="aatc-right-bar">
        <table id="aatc_list" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Source</th>
                    <th>Criteria</th>
                    <th>Target</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

            <?php $count; foreach(CPLC_DB_Utils::Fetch_aatc_data() as $record): ?>
                <tr>
                    <td><?php echo ++$count; ?></td>
                    <?php if($record->type === 'products'): ?>
                        <td><?php echo CPLC_DB_Utils::product_name($record->source_ids);  ?></td>
                    <?php else: ?>
                        <td><?php echo CPLC_DB_Utils::get_product_category_by_id($record->source_ids);  ?></td>
                    <?php endif; ?>
                    <td><?php echo $record->type; ?></td>
                    
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

                    <td><?php echo $record->date_start; ?></td>
                    <td><?php echo $record->date_end; ?></td>
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
