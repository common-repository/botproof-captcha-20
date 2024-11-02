<?php
/*
Plugin Name: BotProof Captcha 2.0
Plugin URI: http://www.botproof.com/wordpress.html
Description: This plugin provides the next generation in captcha technology, BotProof Captcha 2.0,  to a WordPress blog comment form.  The plugin is currently version 0.9.6.8 Beta.  We welcome your comments.
Version: 0.9.6.8
Author: BotProof LLC
Author URI: http://www.BotProof.com
*/

/*  Copyright 2009  BotProof LLC  (email : wordpress@botproof.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
*/

$plugin_ver = "0.9.6.8";

$start_time = 0;
		
if ( isset( $_SERVER["REQUEST_TIME" ] ) ) { 
	$start_time = $_SERVER[ "REQUEST_TIME" ]; 
} else {
	$start_time = time();
}

$bpcaptcha_opt = get_option( 'bpcaptcha' ); 

function delete_preferences() {
	delete_option( 'bpcaptcha' );
}

//register_deactivation_hook( __FILE__, 'delete_preferences' );

$option_defaults = array (
	'acct_id'	 => '', 
	'acct_pwd'	 => '', 
	'acct_user'  => '',
	'bp_pubkey'  => '', 
	'bp_privkey' => '',
	'bp_use_encryption' => '0',
	'bp_use_adembed' => '0',
);

add_option( 'bpcaptcha', $option_defaults, 'BotProof Captcha Default Options', 'yes' );

function bpcaptcha_wp_hash_comment($id)
{
	global $bpcaptcha_opt;
   
	if (function_exists('wp_hash'))
		return wp_hash(BPCAPTCHA_WP_HASH_COMMENT . $id);
	else
		return md5(BPCAPTCHA_WP_HASH_COMMENT . $bpcaptcha_opt['acct_pwd'] . $id);
}

function botproof_comment_form() {
	global $bpcaptcha_opt;
	global $plugin_ver;
	global $wp_version;
	global $start_time;
	
	if ( 'error' == $_GET['berror'] )
		echo '<p>Incorrect captcha entered.  Please try again.</p>';
			
	$lang = 'unknown';
		
	if ( isset( $_SERVER[ "HTTP_ACCEPT_LANGUAGE" ] ) ) { 
		$lang = $_SERVER[ "HTTP_ACCEPT_LANGUAGE" ]; 
	}
	
	$rtime = date ( "Y-m-d H:i:s", $start_time );
	
	if ( true == $bpcaptcha_opt['bp_use_adembed'] ) {
		$use_adembed = 'true';
	} else {
		$use_adembed = 'false';
	}
		
	echo'<script id="wordpress" type="text/javascript" language="Javascript" src="http://botproof.net/qd/wordpress.jsp?a='.$bpcaptcha_opt['acct_id'].'&amp;i='.$_SERVER['REMOTE_ADDR'].'&amp;serverip='.$_SERVER['SERVER_ADDR'].'&amp;servername='.$_SERVER['SERVER_NAME'].'&amp;install_version='.$plugin_ver.'&amp;product=wordpress'.$wp_version.'&amp;serverpath='.urlencode(__FILE__).'&amp;lang='.$lang.'&amp;rtime='.$rtime.'&amp;use_adembed='.$use_adembed.'"></script>';		
	echo'<div id="unreg_div">';
	echo'</div>';
	echo'<div id="submit_button_loc"></div>';
	echo'<script type="text/javascript" language="Javascript">';
	echo'  function unreg() { ';
	echo'    var div1 = document.getElementById("unreg_div");';
	echo'    var div2 = document.createElement("unregistered");';
	echo'    div2.innerHTML = \'<br /><table border="2" bordercolor="#322D4F">\' +';   
	echo'      \'<TR>\' + ';
	echo'	   \'	<TD colSpan=3><div id="bp_cap"><a href="http://www.botproof.com/index.php?option=com_user&amp;task=register#content"><img src="http://www.botproof.com/logos/unregistered.gif" alt="botproofrules" name="bp_dummy" id="bp_dummy"></img></a></div></TD>\' + ';
	echo'	   \'</TR>\' + ';
	echo'	   \'<TR>\' + ';
	echo'	   \'	<TD bgcolor="#9EB6BE"><font face="Arial">UNREGISTERED - Click <a href="http://www.botproof.com/index.php?option=com_user&amp;task=register#content">here</a> <br />to get a free BotProof account.</font></TD>\' + ';
	echo'	   \'	<TD bgcolor="#9EB6BE"><P><font face="Arial">Powered by <br /><a href="http://www.botproof.com/index.php?option=com_user&amp;task=register#content">BotProof</a></font></P></TD>\' + ';
	echo'	   \'	<TD><img SRC="http://www.botproof.com/logos/tiny_logo.gif" alt="botproofrules"></img></TD>\' + ';
	echo'	   \'</TR>\' + ';
	echo'      \'</table><br />\';';
	echo'    div1.appendChild(div2);';
	echo'  }';
	echo'  var bp_captcha_image = document.getElementById(\'bp_captcha\');';
	echo'  if ( null == bp_captcha_image ) { ';
	echo'    unreg();';
	echo'  }';
	echo'    var btnSubmit = document.getElementById("submit");';
	echo'    btnSubmit.parentNode.removeChild(btnSubmit);';
	echo'    document.getElementById("submit_button_loc").appendChild (btnSubmit);';
	echo'    document.getElementById("submit").tabIndex = 6;';
	echo'    if ( typeof _bpcaptcha_wordpress_savedcomment != "undefined")';
	echo'        document.getElementById("comment").value = _bpcaptcha_wordpress_savedcomment;';
	echo'</script>';
}

add_action( 'comment_form', 'botproof_comment_form' );

$bpcaptcha_saved_error = '';

function bpcaptcha_wp_check_comment( $comment_data ) {
	global $bpcaptcha_saved_error;
   	
	if ( '' == $comment_data['comment_type'] ) { 
		$bpcaptcha_response = bpcaptcha_check_answer ( 'no priv key', $_SERVER['REMOTE_ADDR'], $_POST['image_url'], $_POST['attempt'] );
		
		if ( $bpcaptcha_response ) {
			return $comment_data;
		}
		else {
			$bpcaptcha_saved_error = 'error';
			return $comment_data;
		}
	}

	return $comment_data;
}

function bpcaptcha_wp_relative_redirect( $location, $comment ) {
	global $bpcaptcha_saved_error;
	
	if( $bpcaptcha_saved_error != '' ) { 
		$location = substr( $location, 0, strrpos( $location, '#' ) ) .
			( (strrpos( $location, '?' ) === false) ? '?' : '&' ) .
			'bcommentid=' . $comment->comment_ID . 
			'&berror=' . $bpcaptcha_saved_error .
			'&bchash=' . bpcaptcha_wp_hash_comment ($comment->comment_ID) . 
			'#commentform';
	}
	
	return $location;
}

function bpcaptcha_wp_saved_comment() {
	if (!is_single() && !is_page())
		return;
	  
	if ($_GET['bcommentid'] && $_GET['bchash'] == bpcaptcha_wp_hash_comment ($_GET['bcommentid'])) {
		$comment = get_comment( $_GET['bcommentid'] );
		
		$com = preg_replace( '/([\\/\(\)\+\;\'\"])/e','\'%\'.dechex(ord(\'$1\'))', $comment->comment_content );
		$com = preg_replace( '/\\r\\n/m', '\\\n', $com );

		echo '<script type="text/javascript">
			var _bpcaptcha_wordpress_savedcomment =  "' . $com  .'";
			_bpcaptcha_wordpress_savedcomment = unescape(_bpcaptcha_wordpress_savedcomment);
			</script>
		';
		
		wp_delete_comment( $comment->comment_ID );
	}
}

add_filter( 'wp_head', 'bpcaptcha_wp_saved_comment', 0 );
add_filter( 'preprocess_comment', 'bpcaptcha_wp_check_comment', 0 );
add_filter( 'comment_post_redirect', 'bpcaptcha_wp_relative_redirect', 0 , 2 );

function bpcaptcha_check_answer ( $privkey, $remoteip, $challenge, $response, $extra_params = array() ) {
	global $bpcaptcha_opt;
	
	$http_response = _bpcaptcha_http_post ( 'botproof.net', '/qd/CompareAttempt2?account_id='.$bpcaptcha_opt['acct_id'].'&password='.$bpcaptcha_opt['acct_pwd'].'&string_id='.$challenge.'&attempt='.$response.'&remoteip='.$remoteip );

	$answers = explode ( "\r\n", $http_response[1] );
   
	return ( 0 == strcmp( $answers[4], 'yes<br/>' ) );
}

function _bpcaptcha_http_post( $host, $path, $port = 80 ) {
	$http_request  = "POST $path HTTP/1.0\r\n";
	$http_request .= "Host: $host\r\n";
	$http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
	$http_request .= "Content-Length: " . strlen( $req ) . "\r\n";
	$http_request .= "User-Agent: BotProof/PHP\r\n\r\n";

	$response = '';
	
	if( false == ( $fs = @fsockopen( $host, $port, $errno, $errstr, 10 ) ) ) 
		die ( 'Could not open socket' );

	fwrite( $fs, $http_request );

	while ( !feof( $fs ) )
		$response .= fgets( $fs, 1160 ); 
  
	fclose( $fs );
	$response = explode( "\r\n\r\n", $response, 3 );

	return $response;
}

function bpcaptcha_wp_add_options_to_admin() {
	add_options_page( 'BotProof Captcha', 'BotProof Captcha', 'manage_options', __FILE__, 'bpcaptcha_wp_options_subpanel' );
}

function configAcctRem() {
	if ( 'on' == $_POST['bp_use_adembed'] ) {
		$adem = 'true';
	} else {
		$adem = 'false';
	}

	$rand = mt_rand(1, 9999);

	$http_resp = _bpcaptcha_http_post ( 'botproof.net', '/qd/ConfigureAccountRemote?user_id='.$_POST['bpcaptcha_opt_acct_id'].'&password='.$_POST['bpcaptcha_opt_acct_pwd'].'&use_adembed='.$adem.'&rand='.$rand );

	$ans = explode ( "\r\n", $http_resp[1] );
	
	if ( 'HTTP/1.1 200' == substr($http_resp[0], 0, 12 ) ) {
		//echo '<div id="message" class="updated fade"><p><strong>'.$http_resp[1].'</strong></p></div>';
	} elseif ( 'HTTP/1.1 400' == substr($http_resp[0], 0, 12 ) ) {			
		echo '<div id="message" class="updated fade">';
		echo '	<p>';
		echo '		<strong>';
		echo '			<h3>Invalid Account ID</h3>';
		echo '			<hr/>';
		echo '			<p><b>Error:</b>  Your changes cannot be sent to the BotProof.net server.</p>';
		echo '			<p><b>Description:</b>  The Account ID you entered is either blank, or cannot be found on our server.  Please check to make sure you have entered your 36-character (including dashes) BotProof Account ID below.  If you do not have one, get a free account by <a href="http://www.botproof.com/index.php?option=com_user&task=register#content" target="_blank">clicking here</a>.</p>';
		echo '			<hr/>';
		echo '			<h4>BotProof Error Code BP400</h4>';
		echo '		</strong>';
		echo '	</p>';
		echo '</div>';
	} elseif ( 'HTTP/1.1 401' == substr($http_resp[0], 0, 12 ) ) {
		echo '<div id="message" class="updated fade">';
		echo '	<p>';
		echo '		<strong>';
		echo '			<h3>Invalid Password</h3>';
		echo '			<hr/>';
		echo '			<p><b>Error:</b>  Your changes cannot be sent to the BotProof.net server.</p>';
		echo '			<p><b>Description:</b>  The Password you entered is either blank, or cannot be authenticated on our server.  Please check to make sure you have entered your password correctly below.  Your password IS case-sensitive.  If you do not have an AccountID and Password, get a free account by <a href="http://www.botproof.com/index.php?option=com_user&task=register#content" target="_blank">clicking here</a>.</p>';
		echo '			<hr/>';
		echo '			<h4>BotProof Error Code BP401</h4>';
		echo '		</strong>';
		echo '	</p>';
		echo '</div>';
	} else {
		echo '<div id="message" class="updated fade"><p><strong>'.$http_resp[1].'</strong></p></div>';
	}
}

function bpcaptcha_wp_options_subpanel() {
	$optionarray_def = array (
		'acct_id'	 => '',
		'acct_pwd' 	 => '',
		'acct_user'  => '',
		'bp_pubkey'  => '',
		'bp_privkey' => '',
		'bp_use_encryption' => '0',
		'bp_use_adembed' => '0',
	);

	add_option( 'bpcaptcha', $optionarray_def, 'BotProof Captcha Options' );

	if ( isset( $_POST['submit'] ) ) {
		$optionarray_update = array (
			'acct_id'	 => $_POST['bpcaptcha_opt_acct_id'],
			'acct_pwd'	 => $_POST['bpcaptcha_opt_acct_pwd'],
			'acct_user'  => $_POST['bpcaptcha_opt_acct_user'],
			'bp_pubkey'  => $_POST['bp_pubkey'],
			'bp_privkey' => $_POST['bp_privkey'],
			'bp_use_encryption' => $_POST['bp_use_encryption'],
			'bp_use_adembed' => $_POST['bp_use_adembed'],
		);

		update_option( 'bpcaptcha', $optionarray_update );
		
		configAcctRem();
	}

	$optionarray_def = get_option( 'bpcaptcha' );

	?>
	
	<!--********************************************************************CONFIG PAGE***********************************************************************************-->
	<div class="wrap">
		<h2>BotProof Captcha 2.0 Options</h2><br /><br />
		<h3>About BotProof Captcha</h3><br /><br /><br />
		<p>BotProof Captcha is a free CAPTCHA service that will change the way you think about protection from spam and bots.  This is the next generation in captcha technology, Captcha 2.0.  No more distorted letters that annoy your users, and no more bots breaking through weak captcha implementations.  BotProof captchas use dynamic information to display hidden symbols in unique ways that are harder for bots to break through, yet easier for your users to read.</p>
		<p>Our technologies are state-of-the art, with many customizable options.  For example, login to <a href="https://botproof.net" target="_blank">BotProof.net</a> using your BotProof Account ID and Password to customize the colors of your captcha.  Because we deliver our captchas over the Internet in real-time, we can deliver a variety of implementations without the need for installing new software.  We can react quickly and enhance the technologies, to always stay one step ahead of the bots.  Our software can also be used to protect your personal information and your identity.  For details, visit the <a href="http://www.botproof.com/">BotProof.com website</a>.</p>
		<p><strong>NOTE</strong>: If you are using any type of cache plugin, you may need to flush or clear your cache for your changes to take effect.</p>
		<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . plugin_basename( __FILE__ ); ?>&updated=true">
			<div class="submit">
				<input type="submit" name="submit" value="<?php _e( 'Update Options' ) ?> &raquo;" />
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">BotProof Account Info</th>
					<td>BotProof Captcha requires a free account at our website.  You can <a href="http://www.botproof.com/index.php?option=com_user&task=register#content" target="0">sign up here</a>.  Once you have an account, enter the information provided into the fields below.
						<br />
						<p class="bp-keys">
							<label class="which-key" for="bpcaptcha_opt_acct_id">Account ID:</label>
							<input name="bpcaptcha_opt_acct_id" id="bpcaptcha_opt_acct_id" size="40" value="<?php  echo $optionarray_def['acct_id']; ?>" />
							<br />
							<label class="which-key" for="bpcaptcha_opt_acct_user">Username:</label>
							<input name="bpcaptcha_opt_acct_user" id="bpcaptcha_opt_acct_user" size="40" value="<?php  echo $optionarray_def['acct_user']; ?>" />
							<br />
							<label class="which-key" for="bpcaptcha_opt_acct_pwd">Password:</label>
							<input type="password" name="bpcaptcha_opt_acct_pwd" id="bpcaptcha_opt_acct_pwd" size="40" value="<?php  echo $optionarray_def['acct_pwd']; ?>" />
						</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">AdEmbed Opt-In (NEW!)</th>
					<td>
						<input type="checkbox" name="bp_use_adembed" id="bp_use_adembed" <?php if( true == $optionarray_def['bp_use_adembed'] ){echo 'checked="checked"';} ?> /> <label for="bp_use_adembed"><b>YES!</b> I want to opt-in to BotProof's AdEmbed Program.</label>
						<br />
						<p> Now Available:  BotProof AdEmbed, where you can <b>MAKE MONEY $$$</b> from your blog, without doing anything.  You've seen advertising plug-ins to earn money from your blog's traffic.  Select the checkbox above to participate in our AdEmbed program, where an ad is integrated right into the captcha itself.  Not only does this bring revenue to you, it strengthens the captcha!  Now hackers and their bots will have to work even harder to filter out the advertisement from the captcha code.  See our plugin FAQ in your readme.txt file for more info.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Encryption Options</th>
					<td>
						<input type="checkbox" name="bp_use_encryption" id="bp_use_encryption" value="0" <?php if( true == $optionarray_def['bp_use_encryption'] ){echo 'checked="checked"';} ?> /> <label for="bp_use_encryption">Enable encryption for BotProof Captcha.  (coming soon)</label>
						<br />
						<label for="bp_pubkey">Public Key:</label>
						<input name="bp_pubkey" id="bp_pubkey" size="40" value="<?php  echo $optionarray_def['bp_pubkey']; ?>" />
						<br />
						<label for="bp_privkey">Private Key:</label>
						<input name="bp_privkey" id="bp_privkey" size="40" value="<?php  echo $optionarray_def['bp_privkey']; ?>" 
						<br />
						<p>If you already have a free BotProof account, <a href="https://botproof.net/cp/LoginProxy?next_servlet=/qd/ConfigureAccountWpf" target="_blank">click here</a> to generate your encryption keys.</p>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" name="submit" value="<?php _e( 'Update Options' ) ?> &raquo;" />
			</div>
		</form>
		<p class="copyright">&copy; Copyright 2009&nbsp;&nbsp;<a href="http://www.botproof.com">BotProof LLC</a></p>
	</div> 
	<!--********************************************************************END CONFIG PAGE*******************************************************************************-->

	<?php

} //end bpcaptcha_wp_options_subpanel()

add_action( 'admin_menu', 'bpcaptcha_wp_add_options_to_admin' );

if ( !( $bpcaptcha_opt['acct_id'] && $bpcaptcha_opt['acct_pwd'] ) && !isset( $_POST['submit'] ) ) {
	function bpcaptcha_warning() {
		$top = 0;
		
		if ( $wp_version <= 2.5 )
			$top = 12.7;
		else
			$top = 7;
		
		echo "<div id='bpcaptcha-warning' class='updated fade-ff0000'><p><strong>BotProof Captcha is not active.</strong>  You must <a href='options-general.php?page=" . plugin_basename( __FILE__ ) . "'>enter your BotProof account information</a> for it to work.</p></div>
			<style type='text/css'>
			#adminmenu { margin-bottom: 5em; }
			#bpcaptcha-warning { position: absolute; top: {$top}em; }
			</style>
		";
	}
   
	add_action( 'admin_footer', 'bpcaptcha_warning' );
   
	return;
}

?>