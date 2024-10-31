<?php
/*
Plugin Name: Ribbon Maker
Plugin URI: http://wordpress.org/extend/plugins/ribbon-maker
Description: When activated, this plugin will put a ribbon of your design, message and custom link on the top right corner of your website.
Author: Al Lamb
Version: 1.6.2
License: GPLv2
Author URI: http://bowie-tx.com
*/

function ribbon_maker_getVersion() {
	return "1.6.2";
}

//Wordpress will call the following function and pass 2 variables to it.
function ribbon_maker_my_plugin_links($links, $file) {
	$plugin = plugin_basename(__FILE__); 
	if ($file == $plugin) // only for this plugin
			return array_merge( $links,
		array( '<a href="http://profiles.wordpress.org/itscoolreally/">' . __('Other Plugins by this author' ) . '</a>' ),
		array( '<a href="http://www.cafepress.com/SupportHypershock" target="_blank">' . __('Support us and buy some swag') . '</a>' )
	);
	return $links;
}
	
//The following is basically a hook into a function in Wordpress called "plugin_row_meta"
add_filter( 'plugin_row_meta', 'ribbon_maker_my_plugin_links', 10, 2 );
	
function ribbon_maker_getDownload() {
	return "http://wordpress.org/extend/plugins/ribbon-maker";
}

function ribbon_maker_admin() {
	add_submenu_page( 'tools.php', 'Ribbon Maker Settings', 'Ribbon Maker', 10, __FILE__, 'ribbon_maker_admin_menu' );
}

function ribbon_maker_isChecked($test,$string) {
	if($test==$string) return "checked";
	return "";
}

function ribbon_maker_was_it_saved($test) {
		if ( $test )
			echo('<div class="updated"><p><strong>Your setting have been saved.</strong></p></div>');
		else
			echo('<div class="error"><p><strong>Your setting have not been saved.</strong></p></div>');
}

function ribbon_maker_convert_db($new,$old) {
//$old is both the name of the old variable and the old value that needs to come forward
	$result = update_option($new,get_option($old));
	delete_option($old);
	return $result;
}

function ribbon_maker_admin_menu() {
	echo('
		<div class="wrap">
		<h2>Ribbon Maker Options</h2><address style="font-size: 8pt; font-weight: 700;">'.ribbon_maker_getVersion().' (<a href="'.ribbon_maker_getDownload().'" target="_blank">Ribbon Maker</a>)</address>
	');
	if (get_option('ribbon_maker_url')) { //convert the database entries
		
		$ribbon_maker = ribbon_maker_convert_db( 'ribbon_maker_url1', 'ribbon_maker_url' );
		$ribbon_maker .= ribbon_maker_convert_db( 'ribbon_maker_title1', 'ribbon_maker_title');
		$ribbon_maker .= ribbon_maker_convert_db( 'ribbon_maker_admin_offset1', 'ribbon_maker_admin_offset' );
		$ribbon_maker .= ribbon_maker_convert_db( 'ribbon_maker_user_offset1', 'ribbon_maker_user_offset' );
		$ribbon_maker .= ribbon_maker_convert_db( 'ribbon_maker_message1', 'ribbon_maker_message' );
		$ribbon_maker .= ribbon_maker_convert_db( 'ribbon_maker_bgcolor1', 'ribbon_maker_bgcolor' );
		$ribbon_maker .= ribbon_maker_convert_db( 'ribbon_maker_fgcolor1', 'ribbon_maker_fgcolor' );
		$ribbon_maker .= ribbon_maker_convert_db( 'ribbon_maker_active1', 'ribbon_maker_active' );

		ribbon_maker_was_it_saved($ribbon_maker);
	}
        
        if ( isset( $_POST['regenerate'] ) ) {
		for($i=1;$i<=4;$i++) {
			if(get_option("ribbon_maker_do_custom$i")=="inactive" && get_option("ribbon_maker_active$i")=="active") { 
				ribbon_maker_create_ribbon($i);
			}
		}
        }

        if ( isset( $_POST['custom']) ) {
		$upload = wp_upload_bits($_FILES["custom_image"]["name"], null, file_get_contents($_FILES["custom_image"]["tmp_name"]));
		if($_FILES['custom_image']['error'] > 0) {
			echo "Error: " . $_FILES["custom_image"]["error"] . "<br />";
		} else {
			//if(exif_imagetype($_FILES["custom_image"]["tmp_name"])==IMAGETYPE_PNG) {
				$new_name = plugin_dir_path(__FILE__) . "ribbon_maker_ribbon".$_POST['ribbon_maker_slot'].".png";
				move_uploaded_file($_FILES["custom_image"]["tmp_name"],$new_name);			
				update_option('ribbon_maker_do_custom'.$_POST['ribbon_maker_slot'],'active');
			/*} else {
				echo "Please upload a png image";
			}
			*/
		}
       }
	if ( isset( $_POST['saving'] ) ) {
		
		$slot=$_POST['ribbon_maker_slot'];
		if($slot<1 || $slot>4) $slot=1; //slot sanity check!
		$str = strtr( $_POST["ribbon_maker_url$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker = update_option( "ribbon_maker_url$slot", $str );
		
		$str = strtr( $_POST["ribbon_maker_title$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_title$slot", $str);
		
		$str = strtr( $_POST["ribbon_maker_z_position$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_z_position$slot", $str );
		
		$str = strtr( $_POST["ribbon_maker_admin_offset$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_admin_offset$slot", $str );
		
		$str = strtr( $_POST["ribbon_maker_user_offset$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_user_offset$slot", $str );
		
		$str = strtr( $_POST["ribbon_maker_user_h_offset$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_user_h_offset$slot", $str );

		$str = strtr( $_POST["ribbon_maker_fade_timer$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_fade_timer$slot", $str );

		//$str = strtr( $_POST['ribbon_maker_message'], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_message$slot", $_POST["ribbon_maker_message$slot"] );
		
		$str = strtr( $_POST["ribbon_maker_bgcolor$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_bgcolor$slot", $str );
		
		$str = strtr( $_POST["ribbon_maker_fgcolor$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_fgcolor$slot", $str );
		
		$str = strtr( $_POST["ribbon_maker_do_custom$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_do_custom$slot", $str );
		
		$str = strtr( $_POST["ribbon_maker_active$slot"], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$ribbon_maker .= update_option( "ribbon_maker_active$slot", $str );
		
		//ribbon_maker_slot is transient so we don't save it
		ribbon_maker_was_it_saved ( $ribbon_maker );
		//echo "preparing to create new image for slot $i<br>";
		if(get_option("ribbon_maker_do_custom$slot")=="inactive" && get_option("ribbon_maker_active$slot")=="active") { 
			//echo "flags are go for creation for slot $i<br>";
			ribbon_maker_create_ribbon($slot);
		}

	}
	
	//display the 4 corner shots
	echo ("<table><tr><th colspan=4 align='center'>Ribbon Preview</th><tr><th>Upper Right</th><th>Lower Right</th><th>Lower Left</th><th>Upper Left</th></tr>");
	echo("<tr>");
	$bgcolor="#9a9a9a";
	for($i=1;$i<=4;$i++) {
		$hilite="<td>";
		if($i==$_POST['ribbon_maker_slot']) $hilite="<td bgcolor='$bgcolor'>";
		echo ("$hilite");
		echo "<img valign='top' width='150' align='center' src='".plugins_url("ribbon_maker_ribbon$i.png",__FILE__)."'><br>";
		echo "</td>";
	}
	echo "</tr>";
	echo "<tr>";
	for($i=1;$i<=4;$i++) {
		$hilite="";
		if($i==$_POST['ribbon_maker_slot']) $hilite=" bgcolor='$bgcolor' ";
		echo "<td $hilite align='center'><form action='' method='post'><input type='hidden' name='choosing' value='1'><input type='hidden' name='ribbon_maker_slot' value='$i'><input type='submit' value='Edit Ribbon $i'></form>";
		echo ("</td>");
	}
	echo "</tr>";
	echo "<tr>";
	for($i=1;$i<=4;$i++) {
		$hilite="";
		if($i==$_POST['ribbon_maker_slot']) $hilite=" bgcolor='$bgcolor' ";
		echo "<td $hilite align='center'><form action='' method='post' enctype='multipart/form-data'><input type='hidden' name='custom' value='1'><input type='hidden' name='ribbon_maker_slot' value='$i'><input type='file' name='custom_image'><br><input type='submit' value='Upload Custom Ribbon $i'></form>";
		echo ("</td>");
	}
	echo ("</tr></table>");

        switch($_POST['ribbon_maker_slot']) {
		case 1:
			$announce = "upper right";
			$slot = 1;
			break;
		case 2:
			$announce = "lower right";
			$slot = 2;
			break;
		case 3:
			$announce = "lower left";
			$slot = 3;
			break;
		case 4:
			$announce = "upper left";
			$slot = 4;
			break;
		default:
			$announce = "upper right";
			$slot = 1; //default
			break;
	}
	
	echo ("<ht><b><h3>Now editing the $announce corner.</h3></b><br>");
	echo('
		<form action="" method="post">
		<table class="form-table">
		<tr><td>URL to Link to<br/><span class="ribbon_maker_hint">Insert full HTTP quallifed link. for example: http://bowierocks.com/donate. LEAVE BLANK TO DISABLE.</span></td>
		<td>
		<input type="hidden" name="saving" value="1">
		<input type="hidden" name="ribbon_maker_slot" value="'.$_POST['ribbon_maker_slot'].'"><input type="text" name="ribbon_maker_url'.$slot.'" size="80" value="'.get_option( "ribbon_maker_url$slot",'http://bowierocks.com/ribbon-maker' ).'"></td>
		</tr>
		<tr><td>TITLE for Link<br/><span class="ribbon_maker_hint">This is the message that pops up when you hover over links. LEAVE BLANK TO DISABLE.</span></td>
		<td><input type="text" name="ribbon_maker_title'.$slot.'" size="80" value="'.get_option( "ribbon_maker_title$slot",'Get Support at Bowie-TX.com for Ribbon Maker' ).'"></td>
		</tr>
		<tr><td>MESSAGE for Ribbon<br/><span class="ribbon_maker_hint">If you are not using a custom image, then this TEXT will be used to generate your ribbon.</span></td>
		<td><input type="text" name="ribbon_maker_message'.$slot.'" size="80" value="'.stripslashes(get_option( "ribbon_maker_message$slot", 'Ribbon Maker by Al Lamb' )).'"></td>
		</tr>
		<tr><td>BGCOLOR of Ribbon<br/><span class="ribbon_maker_hint">This is the color of the objects that make up the ribbon.</span></td>
		<td><input class="ribbon_maker_class_color" type="text" name="ribbon_maker_bgcolor'.$slot.'" size="10" maxlength=7 value="'.get_option( "ribbon_maker_bgcolor$slot",'000000' ).'"></td>
		</tr>
		<tr><td>FGCOLOR of Ribbon<br/><span class="ribbon_maker_hint">This is the color of the text comprising the message.</span></td>
		<td><input class="ribbon_maker_class_color" type="text" name="ribbon_maker_fgcolor'.$slot.'" size="10" maxlength=7 value="'.get_option( "ribbon_maker_fgcolor$slot",'ffffff' ).'"></td>
		</tr>
		<tr><td>Z Positioning<br/><span class="ribbon_maker_hint">Enter a positive number to float the graphic higher and a negative number to float the graphic lower. I recommend 11000 as the search blog box is set at 9999.</span></td>
		<td><input type="text" name="ribbon_maker_z_position'.$slot.'" size="5" maxlength=5 value="'.get_option( "ribbon_maker_z_position$slot",'0' ).'"></td>
		</tr>
		<tr><td>Admin Vertical Offset<br/><span class="ribbon_maker_hint">Enter a positive number to push the ribbon down, negative for up. Suggest 28 to offset the ADMIN bar.</span></td>
		<td><input type="text" name="ribbon_maker_admin_offset'.$slot.'" size="5" maxlength=5 value="'.get_option( "ribbon_maker_admin_offset$slot",'0' ).'"></td>
		</tr>
		<tr><td>User Vertical Offset<br/><span class="ribbon_maker_hint">Enter a positive number to push the ribbon down, negative for up. Suggest 28 to offset the USER bar.</span></td>
		<td><input type="text" name="ribbon_maker_user_offset'.$slot.'" size="5" maxlength=5 value="'.get_option( "ribbon_maker_user_offset$slot",'0' ).'"></td>
		</tr>

		<tr><td>Horizontal Offset<br/><span class="ribbon_maker_hint">Enter a positive number to move the ribbon left or right. Positive for rightward and negative for leftward. Experiment to find what works best for you. Default is 0.</span></td>
		<td><input type="text" name="ribbon_maker_user_h_offset'.$slot.'" size="5" maxlength=5 value="'.get_option( "ribbon_maker_user_h_offset$slot",'0' ).'"></td>
		</tr>

		<tr><td>Fadeout Timer<br/><span class="ribbon_maker_hint">Enter a number other than 0 to have the banner fade out of view in seconds.</span></td>
		<td><input type="text" name="ribbon_maker_fade_timer'.$slot.'" size="5" maxlength=5 value="'.get_option( "ribbon_maker_fade_timer$slot",'0' ).'"></td>
		</tr>

		<tr><td>Custom Ribbon On<br/><span class="ribbon_maker_hint">Use the custom uploaded ribbon.</span></td>
		<td><input type="radio" name="ribbon_maker_do_custom'.$slot.'" value="active" '.ribbon_maker_isChecked('active',get_option("ribbon_maker_do_custom$slot")).'></td>
		</tr>
		
		<tr><td>Custom Ribbon Off<br/><span class="ribbon_maker_hint">Don\'t use the custom uploaded ribbon.</span></td>
		<td><input type="radio" name="ribbon_maker_do_custom'.$slot.'" value="inactive" '.ribbon_maker_isChecked('inactive',get_option("ribbon_maker_do_custom$slot")).'></td>
		</tr>
		
		<tr><td>Make Ribbon Active<br/><span class="ribbon_maker_hint">If checked, the Ribbon will be visible on your blog.</span></td>
		<td><input type="radio" name="ribbon_maker_active'.$slot.'" value="active" '.ribbon_maker_isChecked('active',get_option("ribbon_maker_active$slot")).'></td>
		</tr>
		
		<tr><td>Make Ribbon In-Active<br/><span class="ribbon_maker_hint">If checked, the Ribbon will NOT be visible on your blog.</span></td>
		<td><input type="radio" name="ribbon_maker_active'.$slot.'" value="inactive" '.ribbon_maker_isChecked('inactive',get_option("ribbon_maker_active$slot")).'></td>
		</tr>
		
		<hr />
		<tr><td colspan="2"><hr /></td></tr>
		<tr><td><input class="button-primary" type="submit" name="submit" value="Save Changes" /></td><td>&nbsp;</td></tr>
		</table>
		</form>
		<form action="" method="post">
		<table class="form-table">
		<tr><td><input class="button-primary" type="submit" name="regenerate" value="Regenerate Images" /><span class="ribbon_maker_hint">Do this after saving.</span></td></tr>
		</table>
		</form>
		</div>
	' );
}

function ribbon_maker_admin_head() {
	echo( '
		<script type="text/javascript" src="'.plugins_url("ribbon_maker_jscolor/ribbon_maker_jscolor.js",__FILE__).'"></script>
		<style type="text/css">
		.ribbon_maker_admin_hint {
		font-size: 7pt;
		font-style: italic;
		color: #080;
		}
		</style>
	' );
}

function ribbon_maker_admin_footer() {
	echo ('
		<head>
		<META HTTP-EQUIV="EXPIRES" CONTENT="0">
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		</head>
	');
}

add_action( 'admin_head', 'ribbon_maker_admin_footer');
add_action( 'admin_footer', 'ribbon_maker_admin_footer');
add_action( 'admin_menu', 'ribbon_maker_admin' );
add_action( 'admin_head', 'ribbon_maker_admin_head' );

function ribbon_maker_get_color($sample,$color) {
	switch($color) {
		case "red":
			$sample = substr($sample,0,2);
			break;
		case "green":
			$sample = substr($sample,2,2);
			break;
		case "blue":
			$sample = substr($sample,4,2);
			break;
		default:
			$sample = "00"; //should never get this! but just in case
		}
	return hexdec($sample);
}

function ribbon_maker_create_ribbon($slot) {
	$string = get_option('ribbon_maker_message'.$slot);
	$bgcolor = get_option('ribbon_maker_bgcolor'.$slot);
	$fgcolor = get_option('ribbon_maker_fgcolor'.$slot);
	$font   = 5;
	$width  = ImageFontWidth($font) * strlen($string)+ImageFontWidth($font)*8;
	$height = ImageFontHeight($font)+8;
	$im = imagecreatetruecolor ($width,$height);
	
	$back = imagecolorallocate($im, 0,0,0);
	$draw_color = imagecolorallocate ($im, (int)ribbon_maker_get_color($bgcolor,"red"), (int)ribbon_maker_get_color($bgcolor,"green"), (int)ribbon_maker_get_color($bgcolor,"blue"));
	$text_color = imagecolorallocate ($im, (int)ribbon_maker_get_color($fgcolor,"red"), (int)ribbon_maker_get_color($fgcolor,"green"), (int)ribbon_maker_get_color($fgcolor,"blue"));
	
	//well since we are building a ribbon, let's nuke it!
	unlink(plugin_dir_path(__FILE__)."ribbon_maker_ribbon$slot.png");
	
	//imagefill($im,0,0,$back);
	
	imageline($im, 0,2,$width,2,$draw_color);
	imageline($im, 0,3,$width,3,$draw_color);

	imagefilledrectangle($im,0,5,$width,$height-5,$draw_color);

	imageline($im, 0,$height-3,$width,$height-3,$draw_color);
	imageline($im, 0,$height-2,$width,$height-2,$draw_color);

	imagestring ($im, $font, $width/2-(strlen($string)*ImageFontWidth($font))/2, 4, stripslashes($string), $text_color);
	$rotation = (-90*($slot-1))+45;
	switch($slot) {
		case 1:
			$rotation = 45;
			break;
		case 2:
			$rotation = -45;
			break;
		case 3:
			$rotation = 45;
			break;
		case 4:
			$rotation = -45;
			break;
	}
	$new_img = imagerotate ($im, 360-$rotation, 0);

	//now we shall try and crop the image and thus make the ribbon flush
	//all in one go
	imagedestroy ($im);
	$newWidth=imagesx($new_img)-ImageFontWidth($font);
	$newHeight=imagesy($new_img)-ImageFontHeight($font);
	$im = imagecreatetruecolor($newWidth,$newHeight);
	
	/*
	bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	*/
	$dst_x=0;
	$dst_y=0;
	$dst_w=imagesx($im);
	$dst_h=imagesy($im);
	switch($slot) {
		case 1:
			imagecopyresampled($im,$new_img,$dst_x,$dst_y,0,ImageFontHeight($font),$newWidth,$newHeight,imagesx($new_img)-ImageFontWidth($font)*2,imagesy($new_img)-ImageFontHeight($font));
			break;
		case 2:
			imagecopyresampled($im,$new_img,$dst_x,$dst_y,0,ImageFontHeight($font),$newWidth,$newHeight,imagesx($new_img)-ImageFontWidth($font)*3.3,imagesy($new_img)-ImageFontHeight($font)*2.7);
			break;
		case 3:
			imagecopyresampled($im,$new_img,$dst_x,$dst_y,ImageFontWidth($font)*2.7,0,$newWidth,$newHeight,imagesx($new_img),imagesy($new_img)-ImageFontHeight($font)*1.8);
			break;
		case 4:
			imagecopyresampled($im,$new_img,$dst_x,$dst_y,ImageFontWidth($font)*2.7,ImageFontHeight($font)*1.8,$newWidth,$newHeight,imagesx($new_img),imagesy($new_img));
			break;
	}

	imagecolortransparent($im,$back);

	//imagepng ($new_img,plugin_dir_path(__FILE__)."ribbon_maker_ribbon.png");//this actually writes out the image!
	imagepng ($im,plugin_dir_path(__FILE__)."ribbon_maker_ribbon$slot.png");//this actually writes out the image!
	imagedestroy ($new_img);
	imagedestroy ($im);
}

function ribbon_maker_add_fader() {
	wp_enqueue_script(
		'ribbon_maker_jquery',
		plugins_url('jquery-1.8.1.js', __FILE__)
	);
	wp_enqueue_script(
		'ribbon_maker_grab_jquery',
		plugins_url('ourJquery.js', __FILE__)
	);
}    
 
function ribbon_maker_add_cookie_mgr() {
	wp_enqueue_script(
		'ribbon_maker_cookies',
		plugins_url('cookies.js', __FILE__)
	);
}

add_action('wp_enqueue_scripts', 'ribbon_maker_add_cookie_mgr');
add_action('wp_enqueue_scripts', 'ribbon_maker_add_fader');

function render_ribbon_maker() {
	for ($i=1;$i<=4;$i++)
	if(get_option("ribbon_maker_active$i")=="active") {
		if(is_admin_bar_showing()) 
			$offset = get_option("ribbon_maker_admin_offset$i");
		else
			$offset = get_option("ribbon_maker_user_offset$i");
		
		$h_offset = get_option("ribbon_maker_user_h_offset$i",'0');
		$z_position = get_option("ribbon_maker_z_position$i",'0');

		$img = plugins_url("ribbon_maker_ribbon$i.png",__FILE__);
		
		$link_url = get_option("ribbon_maker_url$i");
		$link_title = get_option("ribbon_maker_title$i");
		
		$link_head = "";
		if($link_url!="")
			$link_head = "<a target='_blank' class='ribbon-maker' href='$link_url'>";
		if($link_title!="")
			$link_head = "<a target='_blank' class='ribbon-maker' title='$link_title'>";
		if($link_url!="" && $link_title!="")
			$link_head = "<a target='_blank' class='ribbon-maker' href='$link_url' title='$link_title'>";
		
		if($link_head!="")
			$link_tail="</a>";
		else
			$link_tail="";
			
		//now that we have fading, i'm adding cookie management so we can have skipping too!

		switch($i) {
			case 1:
				$tob="top";
				$lor="right";
				break;
			case 2:
				$tob="bottom";
				$lor="right";
				break;
			case 3:
				$tob="bottom";
				$lor="left";
				break;
			default: //ie is this really case 4
				$tob="top";
				$lor="left";
				break;
		}
		echo "<div class=ribbon_maker_$i>$link_head<img src='{$img}' alt='Ribbon Maker' style='position: fixed; $tob: {$offset}px; $lor: {$h_offset}px; z-index: {$z_position}; cursor: pointer;' />$link_tail</div>";

		$timeout = get_option("ribbon_maker_fade_timer$i",'0') * 1000;
		//echo "timeout value is: $timeout";
		$mydiv = "ribbon_maker_$i";
		if($timeout>0)
			echo "<script type=\"text/javascript\">
			  ourJquery(document).ready(function(){
			   setTimeout(function(){
			  ourJquery(\"div.$mydiv\").fadeOut(\"slow\", function () {
			  ourJquery(\"div.$mydiv\").remove();
			      });
			    
			}, $timeout);
			 });
			  </script>";
	}
}

add_action( 'wp_footer', 'render_ribbon_maker' );
?>
