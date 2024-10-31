<?php
/*
Plugin Name: 	PK_Aether
Plugin URI: 	http://www.parotkefalonia.com
Description: 	PK_Aether is a functional plugin to promote and track your events and if needed event registration and pre-payment via PayPal. The front end display is configurable as either a traditional calendar or an accordion of events in any one month.  Back-end administration selects which option to display.  PK_Aether is widget ready so you can easily add either the calendar or an accordion to the sidebar.  Both options (calendar or an accordion) display the_excerpt() with a link to the main post for further information on the event.  Events are categorised "Physical" or "Digital" with a comprehensive event type list.  At ParotKefalonia we name all our Plugins after Greek Gods.  This plugin is named after Aether, one of the Protogenoi, the first-born elemental gods.

Author: 		ParotKefalonia
Author URI: 	http://www.parotkefalonia.com

    Copyright 2009 ParotKefalonia (email : russell@parotkefalonia.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* 
At Parot Kefalonia we name all our Plugins after Greek Gods.  This plugin is named after Aether, is one of the Protogenoi, the first-born elemental gods.

ABOUT AETHER

Aether, in Greek mythology, is one of the Protogenoi, the first-born elemental gods. He is the personification of the upper sky, space, and heaven, and is the elemental god of the "Bright, Glowing, Upper Air." He is the pure upper air that the gods breathe, as opposed to the normal air mortals breathe.

In Hesiod's Theogony, he was the son of Erebus and Nyx and brother of Hemera. Both were noted in passing in Cicero's De Natura deorum, but Hyginus Pref mentioned Khaos as his parent. The aether was also known as Zeus' defensive wall, the bound that locked Tartarus from the rest of the cosmos.

Aether had several offspring, but Hyginus seems to confuse him with Ouranos when saying that Aether had Uranus by Gaia, his daughter. Aergia, a goddess of sloth and laziness, is the daughter of Aether and Gaia. Hyginus is also our source for telling us that Aether is the father of Ouranos and Gaia. But another source tells us that it is just Ouranos who is his child. And like Tartaros and Erebos, in Hellas he might have had shrines but no temples and probably no cult either. In the Orphic hymns, he is mentioned as the soul of the world from which all life emanates. Callimachus, in calling Ouranus Akmonides, claims him as the son of Akmon, and Eustathius in Alcman tells us that the sons of Ouranos were called Akmonidai.

Source: http://en.wikipedia.org/wiki/Aether_(mythology)
*/

 // Add a new submenu under Options:
function pk_aether_add_pages() {
    add_options_page('Events', 'Events', 8, __FILE__, 'pk_aether_settings');
	}
  add_action('admin_menu', 'pk_aether_add_pages');


function pk_aether_settings() {
?>
<style type="text/css">
.PK_postbox h3 
	{
	margin: 				0px; 
	padding: 				10px;
	background-color:		#CCCCCC;
	}

.PK_postbox
	{
	border: 				1px solid #CCCCCC; 
	-webit-border-radius: 	5px;
	-moz-border-radius: 	5px;
	border-radius: 			5px;
	margin-bottom:			20px;
	margin: 20px;
	}

.postbox_inner 
	{
	padding: 				10px;
	}
	</style>
<?php
include 'pk_aether_currencies.php';
include 'pk_aether_settings.php';
}

function pkAether_page_display() {
?>
<table border="0" cellsapcing="1" width="100%" class="PK_cal">
<tr>
<?php
global $wpdb;
$d = date("d");     // Finds today's date
$y = date("Y");     // Finds today's year
$m = date("m");
if(!isset($_GET['PK_m'])) {
$mi = $m+1;
$m = date("m");
echo '<th colspan="5"><th colspan="2" align="right"><a href="?PK_m='.$mi.'">Next &raquo;</a></th>' . "\n";;
}
else {
$m = $_GET['PK_m'];
$mi = $m+1;
$mb = $m-1;
echo '<th colspan="2" align="left">&laquo; <a href="?PK_m='.$mb.'">Back</a></th>' . "\n";
echo '<th colspan="3"></th>';
echo '<th colspan="2" align="right"><a href="?PK_m='.$mi.'">Next</a> &raquo;</th>' . "\n";
}
$no_of_days = date('t',mktime(0,0,0,$m,1,$y)); // This is to calculate number of days in a month
$mn=date('F',mktime(0,0,0,$m,1,$y)); // Month is calculated to display at the top of the calendar
$yn=date('Y',mktime(0,0,0,$m,1,$y)); // Year is calculated to display at the top of the calendar
$j= date('w',mktime(0,0,0,$m,1,$y)); // This will calculate the week day of the first day of the month
for($k=1; $k<=$j; $k++) { // Adjustment of date starting
$adj .="<td>&nbsp;</td>";
}
?>
</tr><tr>
<td colspan="7" align="center" ><strong><?php echo strtoupper($mn).' '.$yn; ?></strong></td>
</tr><tr>
<td width="14%" align="center"><strong>S</strong></font></td><td width="14%" align="center"><strong>M</strong></td><td width="14%" align="center"><strong>T</strong></td><td width="14%" align="center"><strong>W</strong></td><td width="14%" align="center"><strong>T</strong></td><td width="14%" align="center"><strong>F</strong></td><td width="14%" align="center"><strong>S</strong></td></tr><tr>
<script src="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/PK_Aether/scripts/boxover.js"></script>
<?php
for($i=1;$i<=$no_of_days;$i++) {
$date = mktime(0,0,0,$m,$i,$y);
$querystr = " SELECT wposts.*  FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = 'PK Event start' AND wpostmeta.meta_value = '$date' AND wposts.post_status = 'publish' AND wposts.post_type = 'post' ORDER BY wposts.post_date DESC";
$pageposts = $wpdb->get_results($querystr, OBJECT);
if($date = $pageposts) {
		foreach ($pageposts as $post):
		setup_postdata($post);
		ob_start();
		the_ID();
		$the_id = ob_get_contents();
		ob_end_clean();
		$post_id 	= get_post($the_id); 
		$title 		= $post_id->post_title;
		$PK_Event_name 	= get_post_meta($the_id,'PK Event name', true);
		$PK_Event_start = get_post_meta($the_id,'PK Event start', true);
		$PK_Event_end	= get_post_meta($the_id,'PK Event end', true);
		$PK_Event_type 	= get_post_meta($the_id,'PK Event type', true);
		$PK_Event_reservation = get_post_meta($the_id,'PK Event reservation', true);
		$PK_Event_reservation = get_post_meta($the_id,'PK Event reservation', true);
		$PK_Event_start_time = get_post_meta($the_id,'PK Event start time', true);
		$PK_Event_end_time = get_post_meta($the_id,'PK Event end time', true);
	
		if($PK_Event_reservation =" ") {
		$PK_Event_reservation = "Not required";
		}
		else {
		$PK_Event_reservation = $PK_Event_reservation;
		}
		$PK_Event_cost 	= get_post_meta($the_id,'PK Event cost', true);
	
		if($PK_Event_cost=="0.00")
		{
				$popupcontents = 'Event type: '.$PK_Event_type.'<br />Event name: '.$PK_Event_name.'<br />Event date: '.date("d m Y",$PK_Event_start).' - '.$PK_Event_start_time.'<br />Event ends: '.date("d m Y",$PK_Event_end).' - '.$PK_Event_end_time.'<br />Event reservation: '.$PK_Event_reservation.'<p>'.preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2",substr($post_id->post_excerpt,0,350)).'</p>Click to read more' . "\n";
		}
		else
		{
		$popupcontents = 'Event type: '.$PK_Event_type.'<br />Event name: '.$PK_Event_name.'<br />Event date: '.date("d m Y",$PK_Event_start).' - '.$PK_Event_start_time.'<br />Event ends: '.date("d m Y",$PK_Event_end).' - '.$PK_Event_end_time.'<br />Event reservation: '.$PK_Event_reservation.'<br />Cost per person: '.get_option('PK_aether_default_currency').' '.$PK_Event_cost.'<p>'.preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2",substr($post_id->post_excerpt,0,350)).'</p>Click to read more' . "\n";
		}
		echo $adj.'<td align="center" bgcolor="#FFCC00" >' . "\n";
		echo '<a href="?p='.$the_id.'" title="requireclick=[off] header=['.$title.'] body=['.$popupcontents.'] cssheader=[PK_topdiv] cssbody=[PK_botdiv]">'.$i.'</a>' . "\n";
echo '</td>' . "\n";
		endforeach;
}
else {
echo $adj.'<td align="center">'.$i.'</td>' . "\n";
}
$adj='' . "\n";
$j ++;
if($j==7) {
echo "</tr><tr>";
$j=0;
}
}
}

function widget_pk_aether($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>Events calender
  <?php echo $after_title;
  pkAether_page_display();
  echo $after_widget;
}

function pk_aether_init() {
  register_sidebar_widget(__('PK Aether events calendar'), 'widget_pk_aether');    
}
add_action("plugins_loaded", "pk_aether_init");

/* Use the admin_menu action to define the custom boxes */
	add_action('admin_menu', 'pk_aether_add_custom_box');

/* Use the save_post action to do something with the data entered */
	add_action('save_post', 'pk_aether_save_postdata');

/* Adds a custom section to the "advanced" Post and Page edit screens */
function pk_aether_add_custom_box() {
    add_meta_box( 'pk_aether', __( 'Make me an Event', 'pk_aether_textdomain' ),'pk_aether_custom_box', 'post', 'normal' );
	update_option('PK_aether_payment_gateway','No');
}

function pk_aether_custom_box() {
	global $wpdb,$post;
	$postID = $post -> ID;
	require_once ('pk_aether_admin.php');
}

/* When the post is saved, saves our custom data */
function pk_aether_save_postdata( $post_id ) {

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
	}
	return $pk_event_name;
}

function pk_aether_show_info() {
		ob_start();
		the_ID();
		$post_id = ob_get_contents();
		ob_end_clean();
		if(is_home()){}
			else {
			echo '<div id="errormsg">'.$errormessage.'</div>' . "\n";
			$PK_Event_name 	= get_post_meta($post_id,'PK Event name', true);
			$PK_Event_start = get_post_meta($post_id,'PK Event start', true);
			$PK_Event_end	= get_post_meta($post_id,'PK Event end', true);
			$PK_Event_type 	= get_post_meta($post_id,'PK Event type', true);
			$PK_Event_reservation = get_post_meta($post_id,'PK Event reservation', true);
			$PK_Event_reservation = get_post_meta($post_id,'PK Event reservation', true);
			$PK_Event_cost 	= get_post_meta($post_id,'PK Event cost', true);
			
			$PK_Event_start_time	 = get_post_meta($post_id,'PK Event start time', true);
			$PK_Event_end_time 		= get_post_meta($post_id,'PK Event end time', true);
		
		
			$event_details .= 'Event type: '.$PK_Event_type.'<br />' . "\n";
			$event_details .= 'Event name: '.$PK_Event_name.'<br />' . "\n";
			$event_details .= 'Event start: '.$PK_Event_start_time.' hrs on '.date("d m y",$PK_Event_start).'<br />' . "\n";
			$event_details .= 'Event finish: '.$PK_Event_start_time.' hrs on '.date("d m y",$PK_Event_end).'<br />' . "\n";
			
			if($PK_Event_reservation =="Yes") {
			$event_details .= 'Event registration: Required - please complete the form below<br />' . "\n";
			if($PK_Event_cost!="0.00") {
				$event_details .= 'Cost per person: '.$PK_Event_cost;
				}
				if($PK_Event_cost!="0.00") {
				
				$PayPal = get_option('PK_aether_payment_gateway');
				
				if($PayPal =="No")
				{
				$reservations .= '<p><a id="displayText" href="javascript:toggle();">Show registration form</a>' . "\n";
				$reservations .= '<div id="toggleText" style="display: none">';		
				$reservations .= '<form name="reservation_form" method="post" class="PK_form" id="commentform">' . "\n";
				}
				else
				{				
				$reservations .= '<p><a id="displayText" href="javascript:toggle();" title="Event Registration">Event reservation</a>' . "\n";
				$reservations .= '<div id="toggleText" style="display: none">';		
				$reservations .= '<form action="https://www.paypal.com/uk/cgi-bin/webscr" method="post" class="PK_form" id="commentform" >' . "\n";
				$reservations .= '<input type="hidden" name="cmd" value="_ext-enter"><input type="hidden" name="redirect_cmd" value="_xclick">' . "\n";
				$reservations .= '<input type="hidden" name="business" value="'.get_option('PK_aether_gateway_email').'">' . "\n";
				$reservations .= '<input type="hidden" name="item_name" value="'.$PK_Event_name.'">' . "\n";
				$reservations .= '<input type="hidden" name="currency_code" value="'.get_option('PK_aether_default_currency').'">' . "\n";
				}
			
				}
				else {
				$reservations .= '<p><a id="displayText" href="javascript:toggle();">Show registration form</a>' . "\n";
				$reservations .= '<div id="toggleText" style="display: none">';		
				$reservations .= '<form name="reservation_form" method="post" class="PK_form" id="commentform">' . "\n";
				}
				$reservations .= '<fieldset class="PK_fieldset">' . "\n";
				$reservations .= '<legend>'.$PK_Event_name.' Registration form</legend>' . "\n";
				$reservations .= '<input type="hidden" name="item_name" value="'.$PK_Event_name.'">' . "\n";
				$reservations .= '<label for="first_name" class="PK_label">First Name (<span class="PK_red">*</span>)</label><input type="text" id="first_name" name="first_name" size="25" class="required" /><br />' . "\n";
				$reservations .= '<label for="last_name" class="PK_label">Last Name (<span class="PK_red">*</span>)</label><input type="text" id="last_name" name="last_name" size="25" class="required" /><br />' . "\n";
				$reservations .= '<label for="id_company_name" class="PK_label">Company name (if applic.)</label> <input type="text" id="id_company_name" name="company_name" size="25"><br />' . "\n";
				$reservations .= '<label for="id_address1" class="PK_label">Address 1 (<span class="PK_red">*</span>)</label><input type="text" id="id_address1" name="address1" size="35" class="required" /><br />' . "\n";
				$reservations .= '<label for="id_address2" class="PK_label">Address 2</label><input type="text" id="id_address2" name="address2" size="25" /><br />' . "\n";
				$reservations .= '<label for="id_city" class="PK_label">City (<span class="PK_red">*</span>)</label><input type="text" id="id_city" name="city" size="25" class="required" /><br />' . "\n";
				$reservations .= '<label for="id_region" class="PK_label">Region </label><input type="text" id="id_region" name="state" size="25" /><br />' . "\n";
				$reservations .= '<label for="id_zip" class="PK_label">Zip/Postcode (<span class="PK_red">*</span>)</label><input type="text" id="id_zip" name="zip" size="15" class="required" /><br />' . "\n";
				$reservations .= '<label for="email" class="PK_label">E-mail (<span class="PK_red">*</span>)</label><input type="text" id="email" name="email" size="45" class="required email"  /><br />' . "\n";
				$reservations .= '<label for="id_attendees" class="PK_label">No attendees</label>' . "\n";
				$reservations .= '<select name="quantity" id="id_attendees">' . "\n";
				$att=20; 
				for($attno=1; $attno<=($att); $attno++) {
				$reservations .= '<option>'.$attno.'</option>' . "\n";
				}
				$reservations .= '</select>' . "\n";	
				if($PayPal =="No") {
					$reservations .= '<br /><input type="submit" name="cmd_submit" value="Make reservation" class="button-primary" />' . "\n";
					$reservations .= '</fieldset></form>' . "\n";
					$reservations .= '</div>';	
					}
					
				elseif($PK_Event_cost!="0.00") {
					$reservations .= '<br /><label for="id_cost" class="PK_label">Cost p.p.</label><input type="text"  id="id_cost" value="'.$PK_Event_cost.'" name="amount" size="4" /><br />' . "\n";
					$reservations .= '<input style="width: 86px; height: 21px; border: 0px solid; margin-left: 180px;" type="image" src="https://www.paypal.com/en_GB/i/btn/btn_buynow_SM.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!"  />' . "\n";
					$reservations .= '</fieldset></form>' . "\n";
					$reservations .= '</div>';	
					}
					
					
					else {
					$reservations .= '<br /><input type="submit" name="cmd_submit" value="Make reservation" class="button-primary" />' . "\n";
					$reservations .= '</fieldset></form>' . "\n";
					$reservations .= '</div>';	
					}
			}
			else {
			$event_details .= 'Event registration: Not required' . "\n";
			}
		if(isset($_POST['cmd_submit']))
			{
			
			$item_name	= $_POST['item_name']; 
			$first_name	= $_POST['first_name']; 
			$last_name	= $_POST['last_name']; 
			$address1	= $_POST['address1']; 
			$address2	= $_POST['address2']; 
			$city		= $_POST['city']; 
			$state		= $_POST['state']; 
			$zip		= $_POST['zip']; 
			$email		= $_POST['email']; 
			$quantity	= $_POST['quantity'];

			$subject = 'Your registration confirmation for '.$item_name;
			$Enquiry =  $first_name.",";
			$Enquiry.= '\n\nThank you for registering for '.$item_name;
			$Enquiry.= '\n\nRegistration has been confirmed for '.$quantity.' attendees';
			$Enquiry.= "\n\nFull details and registration documents will be sent to:";
			$Enquiry.= "\n ".$address1;
			$Enquiry.= "\n ".$address2;
			$Enquiry.= "\n ".$city;
			$Enquiry.= "\n ".$state;
			$Enquiry.= "\n ".$zip;

			$headers = "From: ".get_option('blogname')."\r\n";
			$headers .= "X-Sender: ".get_option('siteurl')."\r\n";
			$headers .= "X-Mailer: php\r\n"; // mailer
			$headers .= "X-Priority: 1\r\n"; // Urgent message!
			$headers .= "Return-Path: $returnpath\r\n"; // Return path for errors 
			$headers .= "Cc:".get_option('BSSNW_shop_email')."\r\n"; // Return path for errors 

			mail ($email, $subject, $Enquiry, $headers); 
			mail (get_option('BSSNW_shop_email'), $subject, $Enquiry, $headers); 
			}
			
		echo $event_details;
		echo $reservations;
				
		echo '<h2>Event details</h2>' . "\n";
		}
		}
add_shortcode('pkinfo','pk_aether_show_info');
		
function pk_aether_style() {
echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/PK_Aether/PK_Aether.css" type="text/css" media="screen" />' . "\n";
echo '<script src="'.get_bloginfo('wpurl').'/wp-content/plugins/PK_Aether/scripts/js/jquery-1.2.6.min.js" type="text/javascript"></script>' . "\n";
echo '<script src="'.get_bloginfo('wpurl').'/wp-content/plugins/PK_Aether/scripts/js/jquery.validate.min.js" type="text/javascript"></script>' . "\n";
?>
<script type="text/javascript">
$().ready(function() {
// validate the comment form when it is submitted
$("#commentform").validate();
});
function toggle() {
	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText");
	if(ele.style.display == "block") {
    	ele.style.display = "none";
		text.innerHTML = "Event reservation";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "Hide reservation";
	}
} 
</script>
<?php }
add_action('wp_head','pk_aether_style');
add_action('admin_head','pk_aether_style');
?>