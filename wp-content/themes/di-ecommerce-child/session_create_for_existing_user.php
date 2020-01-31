<?php

include_once('session_values.php');
function create_session_for_existing_user($user_id){

	$user_data = get_user_details_for_session($user_id);
	//print_r($user_data);
	$session_store = get_rebow_session();

	$session_store->firstName = $user_data['First_Name'];

	$session_store->lastName = $user_data['Last_Name'];

	$session_store->email = $user_data['email'];

	$session_store->companyName = $user_data['company_name'];

	$session_store->phoneNumber = $user_data['phone_number'];

	$session_store->SecondaryPhoneNumber = $user_data['SecondaryPhoneNumber'];

	$session_store->selecthearus = $user_data['selecthearus'];


	$session_store->payment_type = $user_data['payment_type'];

	$session_store->First_Name = $user_data['First_Name'];

	$session_store->Last_Name = $user_data['Last_Name'];

	$session_store->Card_Number = $user_data['Card_Number'];

	$session_store->Expiry_month = $user_data['Expiry_month'];

	$session_store->Expiry_year = $user_data['Expiry_year'];

	$session_store->billing_address = $user_data['billing_address'];

	$session_store->city = $user_data['city'];

	$session_store->state = $user_data['state'];

	$session_store->zipcode = $user_data['zipcode'];

	set_rebow_session($session_store);

}
function get_user_details_for_session($user_id){
	$query ="SELECT p.payment_type as 'payment_type',p.First_Name as 'First_Name',p.Last_Name as 'Last_Name',p.Card_Number as 'Card_Number',p.Expiry_month as 'Expiry_month',p.Expiry_year as 'Expiry_year',p.city as 'city',p.city as 'city',p.state as 'state',p.billing_address as 'Billing Address',p.zipcode as 'zipcode',c.email as 'email',c.company_name as 'company_name',c.phone_number as 'phone_number',c.SecondaryPhoneNumber as 'SecondaryPhoneNumber',c.hearabotus as 'hearabotus' from payments p JOIN customers c ON p.user_id=c.user_id where p.user_id=$user_id and p.active=1";

	$res = mysql_query($query);

	$row = mysql_fetch_assoc($res);

	return $row;
}
?>