<?php
// The arrays
$physical_event_types = array('Announcement','Audition','Banquet','Campus Activity','Candidate Seminar','Ceremony','Colloquium','Concert','Conference','Deadline','Enrichment','Exam','Exhibition','Festival','Forum','Fundraising','Gathering','Lecture','Meeting','Outreach','Performance','Product launch','Reading','Reception','Recreation','Regional Activity','Screening','Seminar','Sport','Trade show','Training');
$digital_event_types = array('Podcast','Webinar','Product launch');
?>
<table width="100%">
	<tr>
		<td>Event name</td><td><input type="text"  name="pk_event_name" size="50" /></td>
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
<p>
<strong>REMEMBER TO ADD THE SHORTCODE [pkinfo] TO THE EVENT POST OTHERWISE THE EVENT DETAILS WILL NOT SHOW</strong>