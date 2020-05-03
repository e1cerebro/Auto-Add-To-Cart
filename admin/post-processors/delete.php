<?php 


    if($_POST['delete']) { 
         global $wpdb;
         $query = $wpdb->delete( AATC_TABLE_NAME, array( 'id' => $_POST['product_id'] ) );

         if(false == $query) {
            echo  "
                        <div id=\"setting-error-settings_updated\" class=\"error settings-error notice is-dismissible\"> 
                            <p><strong>Record could not be deleted</strong></p>
                            <button type=\"button\" class=\"notice-dismiss\"><span class=\"screen-reader-text\">Dismiss this notice.</span></button>
                        </div>
                  ";            
        }
        else{
            echo  "
                    <div id=\"setting-error-settings_updated\" class=\"updated settings-error notice is-dismissible\"> 
                        <p><strong>Record was successfully deleted</strong></p>
                        <button type=\"button\" class=\"notice-dismiss\"><span class=\"screen-reader-text\">Dismiss this notice.</span></button>
                    </div>
                  ";
        }

    }