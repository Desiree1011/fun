<?php
/**
 * This code retrieves course data from an external API and displays it in the user's
 * My Account area. A merchant has noticed that there's a delay when loading the page.
 * 
 * 1) What changes would you suggest to reduce or remove that delay?

	  

 * 2) Is there any other code changes that you would make?
 	  

 	  Changes made inline and annotated with comments.


 */



//Guessing your going to hook this thing in somewhere, but I made it a class file for quick testing. 
//It outputs a small table with course information when called.




class Test
{
	public function add_my_courses_section() 
	{
		//Looks like it retrieves the API's user ID based off of the current user's WordPress ID, and their _external_api_user_id key in the wp_usermeta table (course I'm sure you have your tables prefixed differently. Since the last parameter of the function is true, that means you want a single return value.
		//Since I don't have the meta_key _external_api_user_id, I'm just arbitraility picking a known good to keep us going.
		$api_user_id = get_user_meta( get_current_user_id(), 'wp_user_level', true );
		//If the API user ID is not found / null, it returns out.
		if ( ! $api_user_id ) { return; }
		//Needs to be an else statement here. Without it, the code attempts to create the $courses and $sso_link variables with a null value and php throws an exception or the variables are set to an empty string.
		else { //Added.
			//Assuming $courses is an array. Not sure where the get_api() function is, it is missing... Commenting it and just hard coding a simple multidimenional array so that I throw in some data.
			//$courses  = $this->get_api()->get_courses_assigned_to_user( $api_user_id );
			$courses = array('courses' => ["Code"=>"1000", "Name"=>"Math", "PercentageComplete"=>"100", "DateCompleted"=>"2/10/2017"],
			 							   ["Code"=>"2000", "Name"=>"English", "PercentageComplete"=>"90", "DateCompleted"=>"2/10/2017"],
			 							   ["Code"=>"3000", "Name"=>"Science", "PercentageComplete"=>"70", "DateCompleted"=>"2/10/2017"],
			 							   ["Code"=>"4000", "Name"=>"Art", "PercentageComplete"=>"100", "DateCompleted"=>"2/10/2017"]);
			//Again, this is commented because I'm just setting random data for example of what the output would look like.
			//$sso_link = $this->get_api()->get_sso_link( $api_user_id );
			$sso_link = "https://gist.github.com/maxrice/87ec90e44a7b437bc7148bc48b189b24";
		} //Added.
		?>
		<!--Standards dictate using external style sheets.-->
		<h2 style="margin-top: 40px;"><?php echo __( 'My Courses', 'text-domain' ); ?></h2>
		<table>
			<thead><tr>
				<th><?php echo __( 'Course Code', 'text-domain' ); ?></th>
				<th><?php echo __( 'Course Title', 'text-domain' ); ?></th>
				<th><?php echo __( 'Completion', 'text-domain' ); ?></th>
				<th><?php echo __( 'Date Completed', 'text-domain' ); ?></th>
			</tr></thead>
			<tbody>
			<?php
			//Looping through $courses array.
			foreach( $courses as $course ) { //Changed : to {, I guess we have different syntax styles?
				?><tr>
				<td><?php echo __( $course['Code'] ); ?></td>
				<td><?php echo __( $course['Name'] ); ?></td>
				<td><?php echo __( $course['PercentageComplete'] ); ?> &#37;</td>
				<td><?php echo __( $course['DateCompleted'] ); ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<p><a href="<?php echo $sso_link ?>" target="_blank" class="button <?php echo $_GET['active_course']; ?>"><?php echo __( 'Course Login', 'text-domain' ); ?></a></p>
		<?php
	}
}