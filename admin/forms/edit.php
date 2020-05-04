
<?php
    require_once plugin_dir_path( __FILE__ ).'../../utils/db-utils.php';

    $data = CPLC_DB_Utils::Fetch_single_aatc_data($query_params)[0];

    $type               = $data->type;
    $target_ids         = $data->target_ids;
    $source_ids         = $data->source_ids;
    $date_start         = $data->start_date;
    $date_end           = $data->end_date;
    $coupon_code        = $data->coupon_code;
    $quantity           = $data->quantity;
    $target_ids_array   = explode(",", $target_ids);
 ?>

<?php if($data): ?>
        <form action="" name='submit' method="post" id="aatc-form">
            <input type="hidden" name="rule_id" value="<?php esc_attr_e($query_params); ?>"/>
            <div class="form-group">
                <label for="criteria">Criteria</label>
                <select data-placeholder="Choose categories..." class="chosen-select" id="criteria" name="criteria">
                    <option <?php echo $type === 'products' ? 'selected' : ''; ?> value="products">Products</option>
                    <option <?php echo $type === 'categories' ? 'selected' : ''; ?> value="categories">Categories</option>
                </select>
            </div>

            <fieldset>
                <legend>IF This is Added To Cart:</legend>

                <div class="form-group categories">
                    <label for="categories">Categories</label>
                    <select   data-placeholder="Choose categories..." class="chosen-select" id="categories" name="categories">
                        <option value="">Select Categories</option>
                        <?php  foreach(CPLC_DB_Utils::get_all_product_categories() as $cat): ?> 
                            <option <?php  echo  $type === 'categories' && $source_ids == $cat->term_id ? 'selected' : ''; ?> value="<?php echo $cat->term_id; ?>">
                            <?php  echo "(#".$cat->term_id.") ".$cat->name; ?>
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
                                        <option  
                                        <?php  echo  $type === 'products' && $source_ids == $product_id  ? 'selected' : ''; ?>
                                        value="<?php echo $product_id; ?>">
                                        <?php echo "(#".$product_id.") ".$variation_product_name; ?>
                                        </option>
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
                                    <option  
                                    <?php  echo  $type === 'products' && $source_ids == $product_id  ? 'selected' : ''; ?>
                                    value="<?php echo $product_id; ?>">
                                    <?php echo "(#".$product_id.") ".$product_name; ?>
                                    
                                    </option>

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
                                    <option 
                                    <?php  echo in_array( $product_id, $target_ids_array)  ? 'selected' : ''; ?>
                                    value="<?php echo $product_id; ?>">
                                    <?php echo "(#".$product_id.") ".$variation_product_name; ?>
                                    </option>
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
                                <option  
                                <?php  echo in_array( $product_id, $target_ids_array)  ? 'selected' : ''; ?>
                                  value="<?php echo $product_id; ?>">
                                <?php echo "(#".$product_id.") ".$product_name; ?>
                                
                                </option>
                
                        <?php endif; ?>
                <?php endforeach;?>
            </select>
            </div>
        </fieldset>

        <fieldset>
            <legend>Schedule</legend>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" value="<?php echo $date_start; ?>" name="start_date" id="start_date">
            </div> 
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" value="<?php echo $date_end; ?>" id="end_date">
            </div> 
        </fieldset>

        <fieldset>
            <legend>Additional Settings</legend>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" value="<?php echo $quantity; ?>" min="1" name="quantity" id="quantity">
            </div> 
            
            <div class="form-group">
                <label for="coupon_code">Coupon Code</label>
                <input type="text" value="<?php echo $coupon_code ; ?>"  name="coupon_code" id="coupon_code">
            </div> 
        </fieldset>

    
        <div class="form-group">
            <?php submit_button('Save Changes', ' primary aatc_button','edit_rule', TRUE); ?>
        </div>     
      
</form> 
<?php endif; ?>