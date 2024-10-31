<div class="wrap">
<h2>PK Aether event calendar settings</h2>
<div class="PK_postbox">
<h3>Make me an event</h3>
<div class="postbox_inner">
<?php
// The arrays
$physical_event_types = array('Announcement','Audition','Banquet','Campus Activity','Candidate Seminar','Ceremony','Colloquium','Concert','Conference','Deadline','Enrichment','Exam','Exhibition','Festival','Forum','Fundraising','Gathering','Lecture','Meeting','Outreach','Performance','Product launch','Reading','Reception','Recreation','Regional Activity','Screening','Seminar','Sport','Trade show','Training');
$digital_event_types = array('Podcast','Webinar','Product launch');
?>
<form method="post" action="" id="commentform">
<table width="100%">
	<tr>
		<td width="220px">Post title</td><td>
		<select name="post_id">
		<?php
		$posts = query_posts($query_string . '&orderby=title&order=asc&posts_per_page=-1');
		if (have_posts()) : while (have_posts()) : the_post(); 
				ob_start();
				the_ID();
				$post_id = ob_get_contents();
				ob_end_clean();
				ob_start();
				the_title();
				$the_title = ob_get_contents();
				ob_end_clean();
				echo '<option value="'.$post_id.'">'.$the_title.' </option>';
		endwhile;
		endif;
		?>
		</select>
		</td>
	</tr><tr>
		<td>Event name</td><td><input type="text"  name="pk_event_name" size="50"  class="required"/></td>
	</tr><tr>
		<td>Type of event</td><td>
		<select name="pk_event_type"  >
			<optgroup label="Physical">
			<?php
			foreach($physical_event_types AS $pk_pkey =>$pk_pval)
			{
			echo '<option value="'.$pk_pval.'">'.$pk_pval.'</option>';
			}
			?>
			</optgroup>
			<optgroup label="Digital">
			<?php
			foreach($digital_event_types AS $pk_dkey =>$pk_dval)
			{
			echo '<option value="'.$pk_dval.'">'.$pk_dval.'</option>';
			}
			?>	
			</optgroup>
			<optgroup label="Other">
			<option value="Not defined">Not defined</option>
			</optgroup>
		</select>
		</td>
	</tr><tr>
		<td>Registration required</td><td><input type="checkbox"  name="pk_event_registration" value="Yes"/></td>
	</tr><tr>
		<td>Event Date</td><td>
		<select  name="pk_event_start_day" >
		<?php
		$pk_a= '31';
		for($pk_d =1; $pk_d <=$pk_a; $pk_d ++)
		{
		echo '<option>'.$pk_d.'</option>';
		}
		?>
		</select>
		<select name="pk_event_start_month" >
		<?php
		$pk_b= '12';
		for($pk_m =1; $pk_m <=$pk_b; $pk_m ++)
		{
		echo '<option value="'.$pk_m.'">'.date('F',mktime(0,0,0,$pk_m,1,date("Y"))).'</option>';
		}
		?>
		</select>
		<select name="pk_event_start_year" >
		<?php
		$pk_c= '3';
		$year = date('Y');
		for($pk_y =0; $pk_y <=$pk_c; $pk_y ++)
		{
		$next_year = $year+$pk_y;
		echo '<option>'.$next_year.'</option>';
		}
		?>
		</select>
		time 
		<select name="pk_event_start_hour" >
		<?php
		$pk_e= '24';
		for($pk_h =1; $pk_h <=$pk_e; $pk_h ++)
		{
		echo '<option>'.$pk_h.'</option>';
		}
		?>
		</select>
		:
		<select name="pk_event_start_min" >
		<option>00</option>
		<option>15</option>
		<option>30</option>
		<option>45</option>
		</select>
		</td>
	</tr><tr>
		<td>Event End time</td><td>
		<select name="pk_event_end_day" >
		<?php
		$pk_a= '31';
		for($pk_d =1; $pk_d <=$pk_a; $pk_d ++)
		{
		echo '<option>'.$pk_d.'</option>';
		}
		?>
		</select>
		<select name="pk_event_end_month" >
		<?php
		$pk_b= '12';
		for($pk_m =1; $pk_m <=$pk_b; $pk_m ++)
		{
		echo '<option value="'.$pk_m.'">'.date('F',mktime(0,0,0,$pk_m,1,date("Y"))).'</option>';
		}
		?>
		</select>
		<select name="pk_event_end_year" >
		<?php
		$pk_c= '3';
		$year = date('Y');
		for($pk_y =0; $pk_y <=$pk_c; $pk_y ++)
		{
		$next_year = $year+$pk_y;
		echo '<option>'.$next_year.'</option>';
		}
		?>
		</select>
		time 
		<select name="pk_event_end_hour" >
		<?php
		$pk_e= '24';
		for($pk_h =1; $pk_h <=$pk_e; $pk_h ++)
		{
		echo '<option>'.$pk_h.'</option>';
		}
		?>
		</select>
		:
		<select name="pk_event_end_min" >
		<option>00</option>
		<option>15</option>
		<option>30</option>
		<option>45</option>
		</select>
		</td>
	</tr><tr>
		<td>Cost p.p</td><td><input type="text"  name="pk_event_cost" size="6" value="0.00" /></td>

	</tr><tr>
		<td><input type="submit" name="cmd_submit" value="Make me an event" class="button-primary" /></td><td></td>
	</tr>
</table>
</form>

<?php
if(isset($_POST['cmd_submit']))
{
	$post_id	 		= $_POST['post_id'];
	$pk_event_name	 		= $_POST['pk_event_name'];
	$pk_event_type  		= $_POST['pk_event_type'];
	$pk_event_registration 	= $_POST['pk_event_registration'];
	$pk_event_start_day 	= $_POST['pk_event_start_day'];
	$pk_event_start_month 	= $_POST['pk_event_start_month'];
	$pk_event_start_year 	= $_POST['pk_event_start_year'];
	$pk_event_start_hour 	= $_POST['pk_event_start_hour'];
	$pk_event_start_min 	= $_POST['pk_event_start_min'];
	$pk_event_start_time 	= $pk_event_start_hour.':'.$pk_event_start_min;
	$pk_event_end_day 		= $_POST['pk_event_end_day'];
	$pk_event_end_month 	= $_POST['pk_event_end_month'];
	$pk_event_end_year 		= $_POST['pk_event_end_year'];
	$pk_event_end_hour 		= $_POST['pk_event_end_hour'];
	$pk_event_end_min 		= $_POST['pk_event_end_min'];
	$pk_event_end_time 		= $pk_event_end_hour.':'.$pk_event_end_min;
	$pk_event_cost 			= $_POST['pk_event_cost'];
	$pk_event_start 		= mktime('0','0','0',$pk_event_start_month,$pk_event_start_day,$pk_event_start_year);
	$pk_event_end 			= mktime('0','0','0',$pk_event_end_month,$pk_event_end_day,$pk_event_end_year);
	
	if (isset($pk_event_name) && !empty ($pk_event_name)){
	update_post_meta($post_id,'PK Event name', $pk_event_name);
	update_post_meta($post_id,'PK Event start', $pk_event_start);
	update_post_meta($post_id,'PK Event end', $pk_event_end);
	update_post_meta($post_id,'PK Event type', $pk_event_type);
	update_post_meta($post_id,'PK Event reservation', $pk_event_registration);
	update_post_meta($post_id,'PK Event cost', $pk_event_cost);
	update_post_meta($post_id,'PK Event start time', $pk_event_start_time);
	update_post_meta($post_id,'PK Event end time', $pk_event_end_time);
	
	echo '<strong>REMEMBER TO ADD THE SHORTCODE [pkinfo] TO THE EVENT POST OTHERWISE THE EVENT DETAILS WILL NOT SHOW</strong>';
	}
}
?>
</div>
</div>
<div class="PK_postbox">
<h3>Your-email address</h3>
<div class="postbox_inner">
<form method="post" action="" id="commentform">
<table>
	<tr>
		<td width="220px"><label for="lbl_email">Your e-mail address</label></td><td><input type="text" name="PK_aether_email" id="lbl_email" value="E-mail address" tabindex="1" size="45" class="required email"/></td>
	</tr><tr>
		<td><input type="submit" value="Set your e-mail" name="cmd_PK_aether_email" tabindex="4" class="button-primary" /></td>
	</tr>
</table>	
</form>
<?php
	// PROCESS THE UPDATE	
	if(isset($_POST['cmd_PK_aether_email'])) {
	$PK_aether_email 	= $_POST['PK_aether_email'];
	update_option('PK_aether_email',$PK_aether_email);
	if(update_option) {
		echo '<p><strong>E-mail set information saved</strong></p>';
		}
	}
?>
</div>
</div>


<div class="PK_postbox">
<h3>PalPal details for payments</h3>
<div class="postbox_inner">
<form name="frm_payment_gateways_paypal" method="post" action="" id="commentform">
<table>
	<tr>
		<td width="220px"><label for="lbl_gateway_email">Your PayPal e-mail address</label></td><td><input type="text" name="PK_aether_gateway_email" id="lbl_gateway_email" value="E-mail address" tabindex="1" size="45" class="required email"/></td>
	</tr><tr>
		<td><label for="lbl_default_currency">Default currency</label></td><td><select name="PK_aether_default_currency" id="lbl_default_currency" tabindex="2">
			<?php
			echo $paypal_currency_list;
			?>
		</select>
		</td>
	</tr><tr>
		<td><input type="submit" value="Set payment information" name="cmd_PK_aether_payment_gateway" tabindex="4" class="button-primary" /></td>
	</tr>
</table>	
</form>
<?php
	// PROCESS THE UPDATE	
	if(isset($_POST['cmd_PK_aether_payment_gateway'])) {
	$PK_aether_gateway_email 	= $_POST['PK_aether_gateway_email'];
	$PK_aether_default_currency	= $_POST['PK_aether_default_currency'];
	update_option('PK_aether_payment_gateway','PayPal');
	update_option('PK_aether_gateway_email',$PK_aether_gateway_email);
	update_option('PK_aether_default_currency',$PK_aether_default_currency);
	if(update_option) {
		echo '<p><strong>Payment information saved</strong></p>';
		}
	}
	// DISPLAY THE PAYMENT GATEWAY INFORMATION	
	echo '<p><strong>Current payment gateway information</strong></p>';
	echo '<ul><li>'.get_option('PK_aether_payment_gateway').'</li>';
	echo '<li>E-mail: '.get_option('PK_aether_gateway_email').'</li>';
	echo '<li>Currency: '.get_option('PK_aether_default_currency').'</li></ul>';
?>
</div>
</div>
<div class="PK_postbox">
<h3>If you like our plugins</h3>
<div class="postbox_inner">
If you are pleased with our product &amp; would like to help us in maintaining &amp; updating it (we will be adding features &amp; upgrades to for you), then please feel free to make a donation.  Thanks.
<p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="text-align:center; width: 250px;">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7873730">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</p>
<p><a href="mailto:russell@parotkefalonia.com">Your suggestions and feedback are always welcome.</a>
</p>
<strong>Our Services</strong>
<ul>
<li>Install (hosting available if required) - full install of the latest version of Wordpress</li>
<li>Upgrade full backup and upgrade current installs</li>
<li>Move a current site to another host and/or web address</li>
<li>Customise themes add logo, hacks and declutering</li>
<li>Troubleshoot a site to fix various problems core files as well as databases</li>
<li>SEO optimization</li>
<li>Using your graphics, pictures logos etc. we develop custom WordPress themes Note: we don't design logos or headers but our design team do <a href="mailto:jmr@razolution.com" title="E-mail our design team">please contact Josh</a> at <a href="http://www.razolution.com" title="The Razolution web site">Razolution</a></li>
<li>We develop plugins and provide support</li>
</ul>	
Thanks for activating and using PK Aether. <i><a href="http://www.parotkefalonia.com" title="Our website">Parot Kefalonia</a></i>
</div>
</div>
<div class="PK_postbox">
<h3>Our Plugins are named after Greek Gods. This plugin is named after Aether, one of the Protogenoi, the first-born elemental gods.</h3>
<div class="postbox_inner">
Aether, in Greek mythology, is one of the Protogenoi, the first-born elemental gods. He is the personification of the upper sky, space, and heaven, and is the elemental god of the "Bright, Glowing, Upper Air." He is the pure upper air that the gods breathe, as opposed to the normal air mortals breathe.
<p>
In Hesiod's Theogony, he was the son of Erebus and Nyx and brother of Hemera. Both were noted in passing in Cicero's De Natura deorum, but Hyginus Pref mentioned Khaos as his parent. The aether was also known as Zeus' defensive wall, the bound that locked Tartarus from the rest of the cosmos.
</p><p>
Aether had several offspring, but Hyginus seems to confuse him with Ouranos when saying that Aether had Uranus by Gaia, his daughter. Aergia, a goddess of sloth and laziness, is the daughter of Aether and Gaia. Hyginus is also our source for telling us that Aether is the father of Ouranos and Gaia. But another source tells us that it is just Ouranos who is his child. And like Tartaros and Erebos, in Hellas he might have had shrines but no temples and probably no cult either. In the Orphic hymns, he is mentioned as the soul of the world from which all life emanates. Callimachus, in calling Ouranus Akmonides, claims him as the son of Akmon, and Eustathius in Alcman tells us that the sons of Ouranos were called Akmonidai.
</p><p>
Source: http://en.wikipedia.org/wiki/Aether_(mythology)
</p>
</div>
</div>