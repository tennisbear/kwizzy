<?php
/**
 * Uses class Kwizzy to create a form, validate form input, and render the
 * success/results page.
 *
 * @author Dennis Slade
 * @since  2012-07-29
 */

@include_once 'kwizzy.class.php';
@include_once 'kwizzy.options.php';


/**
 * Get all the calculated HTML components
 */

$KWIZZY_HTML_MAIN        = Kwizzy::get_main_html();
$KWIZZY_HTML_FORM_OPEN   = Kwizzy::get_form_open_html();
$KWIZZY_HTML_FORM_CLOSE  = Kwizzy::get_form_close_html();
$KWIZZY_HTML_INFO_FORM   = Kwizzy::get_info_form();

$KWIZZY_HTML_RESULTS     = Kwizzy::get_results();
$KWIZZY_INPUT_VALIDATION = Kwizzy::validate_input();
$KWIZZY_ERROR_MESSAGE    = ($KWIZZY_INPUT_VALIDATION) ? ""
                                                      : $FORM_ERROR_MESSAGE;

/**
 * Put the form together. We do this even if form validation is successful
 * (in case the results page wants to show the form again for some reason).
 */

$KWIZZY_HTML_FORM = array
(
	'<noscript><div class="kwizzy_error_message">' . $KWIZZY_ERROR_MESSAGE . '&nbsp;</div></noscript>',
	$KWIZZY_HTML_FORM_OPEN,
	"",
	'<div class="kwizzy_main">',
	$KWIZZY_HTML_MAIN,
	"</div>\n",
	'<div class="kwizzy_form">',
	$KWIZZY_HTML_INFO_FORM,
	'</div>',
	$KWIZZY_HTML_FORM_CLOSE
);

/**
 * If there's an error message then add the message to the form HTML
 */
if ($KWIZZY_ERROR_MESSAGE)
	$KWIZZY_HTML_FORM[] = "<script>alert('$KWIZZY_ERROR_MESSAGE');</script>";

$KWIZZY_HTML_FORM = implode( "\n", $KWIZZY_HTML_FORM );

/**
 * If form validation was successful, show the results page
 */
if ($KWIZZY_INPUT_VALIDATION
    && ($KWIZZY_RESULTS_URI = Kwizzy::get_results_uri()))
{
	define( 'KWIZZY_SHOW_RESULTS', '1' );

	include $KWIZZY_RESULTS_URI;
	exit;
}


/**
 * If we got this far then validation was either unsuccessful or it hasn't taken place yet.
 *
 * For either case, we flow through and let the form be used by whoever's including this file.
 */

/* End of file kwizzy.php */
