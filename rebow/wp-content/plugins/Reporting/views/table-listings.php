<?php
	require_once(ABSPATH. 'wp-admin/includes/class-wp-list-table.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/rebow/db_config.php');

	class OWTListTableClass extends WP_List_Table{
		//define dataset 
		
		//prepare_items
		public function prepare_items(){

			$order_by = isset($_GET['order_by']) ? trim($_GET['order_by']) : "" ;
			$order = isset($_GET['order']) ? trim($_GET['order']) : "" ;
			$search_term = isset($_POST['s']) ? trim($_POST['s']) : "";

			$order_type = isset($_REQUEST['order_type']) ? trim($_REQUEST['order_type']) : "";

			$order_status = isset($_REQUEST['order_status']) ? trim($_REQUEST['order_status']) : "";
			
			//echo "search_term: ".$search_term;
			$datas = $this->wp_list_table_data($order_by,$order,$search_term,$order_type,$order_status);

			$per_page = 5;

			$current_page = $this->get_pagenum();

			$total_items = count($datas);

			$this->set_pagination_args(
				array("total_items"=>$total_items,"per_page"=>$per_page)
			);

			$this->items = array_slice($datas,(($current_page-1) * $per_page), $per_page);

			//print_r($this->items);
			$columns = $this->get_columns();

			$hidden = $this->get_hidden_columns();

			$sortable = $this->get_sortable_columns();

			$this->_column_headers = array($columns,$hidden,$sortable);

		}

		public function wp_list_table_data($orderby='',$order='',$search_term='',$order_type='',$order_status=''){
			//echo "search_term: ".$search_term;
			//$order_type;

			//echo "order_status: ".$order_status;
			if(!empty($search_term)){
				$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1 and b.order_id LIKE '%$search_term%'";
			}else{
				if(empty($orderby) && empty($order)){
					$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1 order by b.order_id asc"; 
				}else
				if($orderby="order_id" && $order=="asc"){
					$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1 order by b.order_id asc"; 
				}else if($orderby="order_id" && $order=="desc"){
					$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1 order by b.order_id desc";
				}
				else
				if($orderby="order_date" && $order=="asc"){
					$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1 order by date(b.created_at) asc"; 
				}else if($orderby="order_date" && $order=="desc"){
					$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1 order by date(b.created_at) desc";
				}
			}
			if(!empty($order_type)){
					$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1 and upper(b.order_type)='$order_type'";
			}
			if(!empty($order_status)){
				$sql = "SELECT a.order_status as 'order_status',u.display_name AS 'display_name',b.order_id as 'order_id',date(b.created_at) AS 'order_date',u.user_email AS 'email',b.order_type as 'order_type',b.product_id as 'product_id', b.box_count as 'box_count',b.added_box_count as 'added_box_count',b.order_time_period as 'order_time_period',b.subtotal as 'subtotal',b.product_price as 'product_price',b.Delivery_Cost as 'Delivery_Cost',b.Pickup_Cost as 'Pickup_Cost',b.Sales_tax as 'Sales_tax',b.total_price as 'total_price',date(b.updated_at) as 'updated_date' from order_tracking a JOIN orders_data b ON a.order_id = b.order_id JOIN wp_users u ON a.user_id = u.ID WHERE b.active=1 AND a.active=1 and a.order_status='$order_status'";
			}
			//echo "SQL: ".$sql;
			$result = mysql_query($sql);

			//$res = mysql_fetch_assoc($result);

			//print_r($res);

			while($row = mysql_fetch_assoc($result)){
				
				$order_id = $row['order_id'];

				$parent_order_id = $row['parent_order_id'];

				$product_id = $row['product_id'];

				$order_type = $row['order_type'];

				$display_name = $row['display_name'];

				$order_date = $row['order_date'];

				$total_price = $row['total_price'];

				$order_status = $row['order_status'];

				$boxes_count = ($row['box_count']+$row['added_box_count']);

				if($order_type=='RENTAL'){
					$shipping_type ='Delivery Empty Boxes';
					$deliver_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

					$shipping_type='Pickup Empty Boxes';
					$pickup_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

				}else if($order_type=='STORAGE'){
					
					$shipping_type='Delivery Empty Boxes';
					$deliver_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

					$shipping_type='Delivery Packed Boxes';
					$deliver_packed_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

					$shipping_type='Pickup Packed Boxes';
					$pickup_packed_boxes_data = get_rental_shipping_data($order_id,$shipping_type);

					$shipping_type='Pickup Empty Boxes';
					$pickup_empty_boxes_data = get_rental_shipping_data($order_id,$shipping_type);
				}

				$data[] =array('order_id'=>$order_id,'display_name'=>$display_name,'order_date'=>$order_date,'order_status'=>$order_status,'delivery_address'=>$deliver_empty_boxes_data['address'],'pickup_address'=>$pickup_empty_boxes_data['address'],'box_count'=>$boxes_count,'product_id'=>$product_id);
			}
			//echo print_r($data);
	        return $data;
		}
		//get_columns
		public function get_columns(){

			$columns = array(
				'order_id'=>'Order ID',
				'display_name'=>'Customer',
				'order_date'=>'Date',
				'order_status'=>'Status',
				'delivery_address'=>'Delivery Address',
				'pickup_address'=>'Pickup Address',
				'box_count'=>'# Box Count',
				'product_id'=>'Product ID'
			);

			return $columns;

		}

		//hidden columns 

		public function get_hidden_columns(){

			$columns = array('product_id');

			return $columns;

		}

		//sortable columns

		public function get_sortable_columns(){

			$columns = array(
				"order_id"=>array("order_id",true),
				"order_date"=>array("order_date",false)
			);

			return $columns;

		}


		//column_default
		public function column_default($item,$column_name){
			switch($column_name){
				case 'order_id':
				case 'display_name':
				case 'order_date':
				case 'order_status':
				case 'delivery_address':
				case 'pickup_address':
				case 'box_count':
				case 'product_id':
					return $item[$column_name];
				default: 
					return 'no value';

			}
		}

		public function extra_tablenav( $which ) {
		   	//global $wpdb, $testiURL, $tablename, $tablet;
		    //$move_on_url = '&cat-filter=';
		    $order_type = isset($_REQUEST['order_type']) ? trim($_REQUEST['order_type']) : "";

		    $order_status = isset($_REQUEST['order_status']) ? trim($_REQUEST['order_status']) : "";
		    if ( $which == "top" ){
		        ?>
		        <div class="alignleft actions bulkactions">
		        <?php
		        $cats = $this->get_order_type_data();

		        $order_status_array = $this->get_order_status_data();
		        //$cats = $wpdb->get_results('select * from '.$tablename.' order by title asc', ARRAY_A);
		        if( $cats ){
		            ?>
		            <select name="cat-filter" class="ewc-filter-cat">
		                <option value="">Order Type</option>
		                <?php
		                foreach( $cats as $cat ){
		                    
		                ?>
		                <?php 
		                if($order_type==$cat){?>
		                	<option value="<?php echo $cat; ?>" selected ><?php echo $cat; ?></option>
		            	<?php }else{?>
		            		 <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
		            	<?php }?>
		               
		                <?php   
		                
		                }
		                ?>
		            </select>
		            <?php   
		        }

		        if( $order_status_array ){
		            ?>
		            <select name="cat-filter1" class="ewc-filter-cat1">
		                <option value="">Order Status</option>
		                <?php
		                foreach( $order_status_array as $status ){
		                    
		                ?>
		                <?php 
		                if($order_status==$status){?>
		                	<option value="<?php echo $status; ?>" selected ><?php echo $status; ?></option>
		            	<?php }else{?>
		            		 <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
		            	<?php }?>
		               
		                <?php   
		                
		                }
		                ?>
		            </select>
		            <?php   
		        }
		        ?>  
		        </div>
		        <?php
		    }
		    if ( $which == "bottom" ){
		        //The code that goes after the table is there

		    }
		}
		public function get_order_type_data(){
			$query = mysql_query("select order_type from order_type_master where status=1");

	        while($row = mysql_fetch_assoc($query)){
	        	$data[] = $row['order_type'];
	        }

	        return $data;
		}

		public function get_order_status_data(){
			$query = mysql_query("select order_status from order_status_master where status=1");

	        while($row = mysql_fetch_assoc($query)){
	        	$data[] = $row['order_status'];
	        }

	        return $data;
		}

	}

	function owt_list_table_layout(){

		$owt_list_table = new OWTListTableClass();

		//calling prepare items from class

		$owt_list_table->prepare_items();
		echo "<form method='post' name='frm_search_post' action='" . $_SERVER['PHP_SELF'] . "?page=Sales'>";
		$owt_list_table->search_box("Search Order","search_order_id");
		echo "</form>";
		$owt_list_table->display();

	}

	owt_list_table_layout();
	?>
	<script>
		jQuery('.ewc-filter-cat').change(function(){
			//alert(1);
		    var catFilter = jQuery(this).val();
		    //alert(catFilter);
		    
		        document.location.href = 'admin.php?page=Sales&order_type='+catFilter;    
		    //}
		});
		jQuery('.ewc-filter-cat1').change(function(){
			//alert(1);
		    var catFilter1 = jQuery(this).val();
		    //alert(catFilter);
		    
		        document.location.href = 'admin.php?page=Sales&order_status='+catFilter1;    
		    //}
		});
	</script>