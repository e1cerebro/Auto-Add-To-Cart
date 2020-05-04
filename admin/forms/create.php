    <form action="" name='submit' method="post" id="aatc-form">
            <div class="form-group">
                <label for="criteria">Criteria</label>
                <select data-placeholder="Choose categories..." class="chosen-select" id="criteria" name="criteria">
                    <option value="products">Products</option>
                    <option value="categories">Categories</option>
                </select>
            </div>

            <fieldset>
                <legend>IF This is Added To Cart:</legend>

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
                <select   data-placeholder="Choose product(s)..." class="chosen-select" name="auto_add_product[]" id="auto_add_product" multiple>

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

        <fieldset>
            <legend>Additional Settings</legend>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" value="1" min="1" name="quantity" id="quantity">
            </div> 
            
            <div class="form-group">
                <label for="coupon_code">Coupon Code</label>
                <input type="text"  name="coupon_code" id="coupon_code">
            </div> 
        </fieldset>
    
        <div class="form-group">
            <?php submit_button('Save Changes', ' primary aatc_button','submit', TRUE); ?>
        </div>     
      
      </form> 