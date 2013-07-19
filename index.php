<?php
/**
 * Sample index file for Kwizzy
 *
 * @author Dennis Slade
 * @since  2012-07-27
 */

@include_once 'kwizzy.php';


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

<?php echo $KWIZZY_HTML_FORM; ?>

<div class="footer">
<!-- footer html starts here -->
	<p> Powered by Kwizzy! </p>
<!-- footer html ends here -->
</div>

</body>
</html>