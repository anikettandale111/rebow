<?php if ( !defined( 'ABSPATH' ) ) exit; ?>


<div class="wrap">
<?php echo "<h2>".__('Subscriber List')."</h2>";?>



<?php
	global $wpdb;
	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;

	$limit = 20;
	$offset = ( $pagenum - 1 ) * $limit;
	$entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}kento_email_subscriber ORDER BY id DESC LIMIT $offset, $limit" );
 

 
?>




<table class='kento_email_subscriber_post widefat'>
    <thead>
        <tr>
        	<!-- 
        	<th scope="col" class="manage-column column-name" style=""><strong>Select</strong></th>
            -->
            <th scope="col" class="manage-column column-name" style=""><strong>Email</strong></th>
            <th scope="col" class="manage-column column-name" style=""><strong>Name</strong></th>
			<th scope="col" class="manage-column column-name" style=""><strong>Delete</strong></th>            
        </tr>
    </thead>



    

    
    
        <?php if( $entries ) { ?>
 
            <?php
            $count = 1;
            $class = '';
            foreach( $entries as $entry ) {
				
				if($count % 2 == 0)
					{
					$class = 'alternate';
					}

				?>
 
            <tr class="<?php echo $class." row_id_".$entry->id;  ?>">
            <!--
            	<td><?php echo "<input type='checkbox' value='".$entry->id."' />"; ?></td>
                -->
                <td><a href='mailto:<?php echo $entry->email; ?>'><?php echo $entry->email; ?></a></td>  
                <td><?php echo $entry->name; ?></td>
                <td><?php echo "<span data-id='".$entry->id."' class='kento_subscribe_delete kento_subscribe_delete_".$entry->id."'></span>"; ?>
                </td>
            </tr>
 
            <?php
                $count++;
            }
            ?>
 
        <?php } else { ?>
        <tr>
            <td colspan="2">No Subscriber Yet</td>
        </tr>
        <?php } ?>  

    
</table>



<?php
 
$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM {$wpdb->prefix}kento_email_subscriber" );
$num_of_pages = ceil( $total / $limit );
$page_links = paginate_links( array(
    'base' => add_query_arg( 'pagenum', '%#%' ),
    'format' => '',
    'prev_text' => __( '&laquo;', 'aag' ),
    'next_text' => __( '&raquo;', 'aag' ),
    'total' => $num_of_pages,
    'current' => $pagenum
) );
 
if ( $page_links ) {
    echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
}
 

?>













</div>