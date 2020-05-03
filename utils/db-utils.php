<?php





    class CPLC_DB_Utils{


        public static function Fetch_aatc_data(){
            global $wpdb;
            $data= $wpdb->get_results( "SELECT * FROM ".AATC_TABLE_NAME);
            $wpdb->flush();
            return $data;
        }

        public static function Fetch_aatc_specific_data($product_id){
            
            global $wpdb;
            
            $query_data = $wpdb->get_results( "SELECT `target_ids`, `date_start`, `date_end`, `status` FROM ".AATC_TABLE_NAME." WHERE `type` = 'products' AND `source_ids` = {$product_id} AND `status` = 'active' ");
            $wpdb->flush();
            return $query_data;
        }

        public static function get_product_from_cats($product_id){
                global $wpdb;
                $category_ids = self::get_product_cat_ids($product_id);
                $processed_cat_ids =  implode(",", $category_ids);

                $cat_data= $wpdb->get_results( "SELECT `target_ids`, `date_start`, `date_end`, `status` FROM ".AATC_TABLE_NAME." WHERE `type` = 'categories' AND `source_ids` IN ({$processed_cat_ids})  AND `status` = 'active'");

                $wpdb->flush();

                return $cat_data;   
        }


        public static function get_product_cat_ids($product_id){
            $terms = get_the_terms( $product_id, 'product_cat' );
            if( $terms){
                $cat_ids = array();
                foreach ( $terms as $term ) {
                    array_push($cat_ids, $term->term_id);
                } 
                return $cat_ids;
            }
            return 0;
        }

        public static function product_name($product_id){
            $product = wc_get_product( $product_id );
            return $product->get_name();
        }

        public static function get_product_category_by_id( $category_id ) {
            $term = get_term_by( 'id', $category_id, 'product_cat', 'ARRAY_A' );
            return $term['name'];
        }

        public static function get_products(){
            $args =  array(
                            'post_type' => 'product',
                            'numberposts' => -1,
                             'post_status' => 'publish',
                            'fields' => 'ids',
                        );
        
            $products  = get_posts($args);
            return $products;
        }

       public function get_product_from_cat(){

        $include_cat = get_option('cplc_include_categories_el');

            $args = array(
                'post_type'             => 'product',
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => 1,
                'posts_per_page'        => '-1',
                'fields' => 'ids',
                'tax_query'             => array(
                    array(
                        'taxonomy'      => 'product_cat',
                        'field'         => 'term_id', //This is optional, as it defaults to 'term_id'
                        'terms'         => $include_cat,
                        'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                    ) 
                )
            );
            return  new WP_Query($args);
        }

        public static function get_products_variations($product_id){
            global $woocommerce, $product, $post;

            $product = wc_get_product( $product_id );

            if ($product->is_type( 'variable' ))  {
                $temp_id_arr = array();
                $available_variations = $product->get_available_variations();
                foreach ($available_variations as $key => $value) 
                { 
                    array_push($temp_id_arr, $value['variation_id']);
                }
                return $temp_id_arr;
            }else{
                return false;
            }

           
        }


        PUBLIC function get_all_product_categories(){
            $taxonomy     = 'product_cat';
            $orderby      = 'name';  
            $show_count   = 0;      // 1 for yes, 0 for no
            $pad_counts   = 0;      // 1 for yes, 0 for no
            $hierarchical = 1;      // 1 for yes, 0 for no  
            $title        = '';  
            $empty        = 0;
        
            $args = array(
                    'taxonomy'     => $taxonomy,
                    'orderby'      => $orderby,
                    'show_count'   => $show_count,
                    'pad_counts'   => $pad_counts,
                    'hierarchical' => $hierarchical,
                    'title_li'     => $title,
                    'hide_empty'   => $empty
            );

            $all_categories = get_categories($args);
            return $all_categories;
        }
    }