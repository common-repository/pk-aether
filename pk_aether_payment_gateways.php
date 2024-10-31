<div class="wrap">
<h2>Payment details</h2>
<form name="frm_payment_gateways_paypal" method="post" action="">
<label for="lbl_gateway_email">Your PayPal e-mail address</label>
<input type="text" name="PK_aether_gateway_email" id="lbl_gateway_email" value="E-mail address" tabindex="2" /><br />
<label for="lbl_default_currency">Default currency</label>
<select name="PK_aether_default_currency" id="lbl_default_currency" tabindex="3">
<?php
echo $paypal_currency_list;
?>
</select><br />
<input type="submit" value="Set payment information" name="cmd_PK_aether_payment_gateway" tabindex="4" class="button-primary" />
</form>
<?php
	// PROCESS THE UPDATE	
	if(isset($_POST['cmd_PK_aether_payment_gateway']))
	{
	$PK_aether_gateway_email 	= $_POST['PK_aether_gateway_email'];
	$PK_aether_default_currency	= $_POST['PK_aether_default_currency'];
	update_option('PK_aether_payment_gateway','PayPal');
	update_option('PK_aether_gateway_email',$PK_aether_gateway_email);
	update_option('PK_aether_default_currency',$PK_aether_default_currency);
	if(update_option)
		{
		echo '<p><strong>Payment information saved</strong></p>';
		}
	}
	// DISPLAY THE PAYMENT GATEWAY INFORMATION	
	echo '<h2>Current payment gateway information</h2>';
	echo get_option('PK_aether_payment_gateway');
	echo get_option('PK_aether_gateway_email');
	echo get_option('PK_aether_default_currency');
?>
</div>