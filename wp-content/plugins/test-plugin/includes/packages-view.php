<?php
/**
 * User capabilities View class to output HTML with capabilities assigne to the user
 *
 * @package    test-plugin
 * @subpackage Admin
 * @author     Yogesh Patil
 * @copyright  
 **/
class PackagesView {
    

    function create_view(){
        echo '<form>';
        $this->get_products_data();
        echo '</form>';
    }
   function  get_products_data(){
        $con = mysql_connect("localhost","root","");
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        //mysql_query('SET names utf8');
        mysql_set_charset('utf8');
        $db = mysql_select_db("rebow");

        $sql="select * from wp_products";

        $result = mysql_query($sql);

        while($row = mysql_fetch_array($result)){
            $product_id = $row['product_id'];
            //$price = get_price($product_id,'2w');
            //$storage_price = get_price($product_id,'1m');
            //echo '<tr>';
            echo '<input type="text" value='.$row['product_name'].'>';
            echo '<br/>';
            echo '<input type="text" value='.$row['product_type'].'>';
            echo '<br/>';
            echo '<input type="text" value='.$row['box_count'].'>';
            echo '<br/>';
            echo '<input type="text" value='.$row['box_count'].'>';
            echo '<br/>';
            //echo '<td><h3> $'.$price.'/2 week</h3></td>';
            //echo '<td><h3> $'.$storage_price.'/ month</h3></td>';
            //echo '<td><a href="packages-view.php?product='.$product_id.'&action=edit">Edit Package</a></td>';
            //echo '</tr>';

        }

   }
}
// end of class PackagesView

