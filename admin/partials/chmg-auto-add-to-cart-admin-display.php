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

require_once plugin_dir_path( __FILE__ ).'../utils/db-utils.php';
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<section class="aatc-main"> 

    <div class="aatc-left-bar">
        <div class="section-title">
            <h2 >Create Auto ADD Rule </h2>
            <small>Lorem ipsum dolor sit amet consectetur adipisicing elit. </small>
        </div>

        <form action="/" method="post" id="aatc-form">

        <div class="form-group">
            <label for="choice_type">Criteria</label>
            <select data-placeholder="Choose categories..." class="chosen-select" id="choice_type" name="choice_type">
                <option value="products">Products</option>
                <option value="categories">Categories</option>
            </select>
        </div>

        <fieldset>
        <legend>IF SELECTED:</legend>

        <div class="form-group categories">
            <label for="choice_type">Categories</label>
            <select data-placeholder="Choose categories..." class="chosen-select" id="choice_type" name="categories">
                <option value="">Select Categories</option>
                <?php foreach(CPLC_DB_Utils::get_all_product_categories() as $cat): ?> 
                    <option value="<?php echo $cat->term_id; ?>">
                    <?php echo $cat->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group products">
            <label for="choice_type">Products</label>
            <select data-placeholder="Choose Product..." class="chosen-select" name="categories">
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
        <label for="auto_add">Products</label>
        <select data-placeholder="Choose categories..." class="chosen-select" name="auto_add_product" id="auto_add">

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
    <div class="form-group">
    <button class="aatc_button submit" type="submit">Save Changes</button>
    </div>     
      
        </form> 
    </div>

    <div class="aatc-right-bar">
        <table id="aatc_list" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name </th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td>Sample Name</td>
                    <td>Shoes</td>
                    <td>$200.00</td>
                    <td><button class="aatc_button edit">Edit</button></td>
                    <td><button class="aatc_button delete">Delete</button></td>
                 </tr>   
            </tbody>
        </table>
    </div>

</section>
