<?php
/**
 * Sample results file for Kwizzy. This file is to be included by Kwizzy,
 * it's meant to never be accessed directly.
 *
 * @author Dennis Slade
 * @since  2012-07-27
 */

if (!defined( 'KWIZZY_SHOW_RESULTS' ))
{
	exit( 'No direct script access allowed' );
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title> I am Kwizzy </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="<?php echo $CSS_LOCATION; ?>kwizzy.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo $JS_LOCATION; ?>kwizzy.js"></script>
</head>
<body class="kwizzy_body wsite-theme-light landing-page wsite-page-index">

<div class="header">
<!-- header html starts here -->

	<p style="text-align: center;"><span style="font-size: 28px; color: #000000;"><span style="font-size: 18px;">
	You'll receive a detailed analysis of your answers that will show you where you <br>stand in living your passions and what you need to do to go to the next level.</span></span>
	</p>
	<p style="border: 1px solid #800080;" align="center"><span style="font-size: 18px; color: #000000;"><strong>BONUS: </strong>You'll also get our FREE Video series that will teach you the <br> core principles for creating more love, fulfillment and meaning <br> in your career, your relationships, your health and your life.</span>
	</p>
	<p><span style="font-size: 28px; color: #000080;"><span style="color: #800080;"><span style="font-size: 18px;"><span style="color: #000000; font-size: 14px;">NOTE: We promise not to share, sell or rent your email to any third party.</span></span></span></span></p>

	<h1 class="kwizzy"> The Love Test! </h1>
	
<!-- header html ends here -->
</div>

<?php echo $KWIZZY_HTML_RESULTS; ?>

<hr>
<div class="mailing_list_signup">
<p> Join Janet's mailing list to gain valuable tips and stay informed of upcoming events. </p>
<p> As a thank you, you will receive a FREE copy of the e-Book 'A Life on Fire'. In this 116 page e-Book, you'll read interviews with nine of the most successful and inspiring people I know, including: Stephen R. Covey, Jack Canfield, Brian Tracy, Marianne Williamson, Janet Attwood, and more! </p>
<p> Simply type in your first name and email address and hit the Subscribe button </p>

<!-- Begin MailChimp Signup Form -->
<div id="mc_embed_signup">
<form action="http://shaylalogan.us2.list-manage.com/subscribe/post?u=154d712abc6915da6302cc967&id=3608484677" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
	
<div class="mc-field-group">
	<label for="mce-FNAME">First Name </label>
	<input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
</div>
<div class="mc-field-group">
	<label for="mce-EMAIL">Email Address </label>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>	<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
<div></div>
</form>
</div>
<!--End mc_embed_signup-->

</div>

<div class="footer">
<!-- footer html starts here -->
	<p> Powered by Kwizzy! </p>
<!-- footer html ends here -->
</div>

</body>
</html>