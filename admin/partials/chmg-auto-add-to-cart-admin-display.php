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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<section class="aatc-main"> 

    <div class="aatc-left-bar">
        <h2>Add/Edit Record</h2>

        <form action="/" method="post">
            <label for="fname">First name:</label><br>
            <input type="text" id="fname" name="fname" value="John"><br>
            <label for="lname">Last name:</label><br>
            <input type="text" id="lname" name="lname" value="Doe"><br><br>
            <input type="submit" value="Submit">
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
