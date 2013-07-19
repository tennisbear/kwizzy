<?php
/**
 * Class Kwizzy, which has most of the logic to build the forms HTML for Kwizzy
 *
 * @author Dennis Slade
 * @since  2012-07-29
 */


/**
 * Generic constants. Many are defined here just as shortcuts (ie, they point
 * to class constants which could be used instead).
 */
define( 'ANSWERS', Kwizzy::ANSWERS );
define( 'AUTO_DECREASING', 'auto_decreasing' );
define( 'AUTO_INCREASING', 'auto_increasing' );
define( 'EMAIL', Kwizzy::EMAIL );
define( 'INPUT_TYPE', Kwizzy::INPUT_TYPE );
define( 'LABEL', Kwizzy::LABEL );
define( 'MANUAL', 'manual' );
define( 'OPTIONAL', 'optional' );
define( 'QUESTION', Kwizzy::QUESTION );
define( 'REQUIRED', Kwizzy::REQUIRED );
define( 'TEXT', Kwizzy::TEXT );
define( 'VALIDATION', Kwizzy::VALIDATION );


/**
 * Class containing most of the logic to build the forms HTML
 *
 * @author Dennis Slade
 * @since  2012-07-29
 *
 */
class Kwizzy
{
	const ANSWERS    = 'answers';
	const CLEAR_ALL  = '<br clear="all">';
	const EMAIL      = 'email';
	const INPUT_TYPE = 'input_type';
	const LABEL      = 'label';
	const QUESTION   = 'question';
	const REQUIRED   = 'required';
	const TEXT       = 'text';
	const VALIDATION = 'validation';
	
	
	/**
	 * Get HTML for the entire quiz form. Currently supports only multiple choice answers.
	 *
	 * @author Dennis Slade
	 * @todo Support answers which aren't multiple choice
	 */
	public static function get_main_html()
	{
		$html = array( self::CLEAR_ALL );
		
		$entries = $GLOBALS['KWIZZY_CONTENT'];
		$index   = 1;
		
		/**
		 * Loop through each question and answer to build the quiz form
		 */
		foreach( $entries as $entry )
		{
			$question    = $entry[ self::QUESTION ];
			$answers     = array_keys( $entry[ self::ANSWERS ] );
			$required    = (isset( $entry[ self::VALIDATION ] ) && $entry[ self::VALIDATION ] == self::REQUIRED )
			                  ? ' required'
			                  : "";
			$radio_list  = array();
			
			$name            = "answer_{$index}";
			$previous_answer = (isset( $_POST[ $name ] )) ? $_POST[ $name ] : "";
			
			/**
			 * Build radio buttons for the answer
			 */
			foreach( $answers as $key => $choice )
			{
				$id      = "{$name}_{$key}";
				$checked = ($previous_answer === $choice) ? ' checked="checked"' : "";
				
				$radio_list[] = "\t\t<div class=\"kwizzy_radio_list\">";
				$radio_list[] = "\t\t\t<input type=\"radio\" name=\"$name\" value=\"{$choice}\" id=\"$id\"$required$checked>";
				$radio_list[] = "\t\t\t<label for=\"$id\">$choice</label>";
				$radio_list[] = "\t\t</div>";
			}
				
			/**
			 * Special formatting if we're this question was required but wasn't answered
			 */
			
			$validation = (isset( $entry[ self::VALIDATION ] )) ? $entry[ self::VALIDATION ] : "";
			
			if ($validation == Kwizzy::REQUIRED
			    && !empty( $_POST )
			    && $previous_answer === "")
			{
				$error_class = ' kwizzy_error';
			}
			else
			{
				$error_class = "";
			}
			
			$html[] = "<div class=\"kwizzy_entry_bullet{$error_class}\">{$index}.</div>";
			$html[] = "<div class=\"kwizzy_entry{$error_class}\">";
			$html[] = "\t<div class=\"kwizzy_question\">$question</div>";
			$html[] = "\t<div class=\"kwizzy_answers\">";
			$html[] = implode( "\n", $radio_list );
			$html[] = "\t</div>";
			$html[] = "</div>";
			
			$index++;
		}
		
		return implode( "\n", $html );
	}
	
	
	/**
	 * Get HTML for opening the form
	 *
	 * @author Dennis Slade
	 */
	public static function get_form_open_html()
	{
		$html = "\n<form action=\"". $_SERVER['PHP_SELF'] ."\" method=\"POST\">";
		
		return $html;
	}
	
	
	/**
	 * Get HTML for the submit button and for closing the form
	 *
	 * @author Dennis Slade
	 */
	public static function get_form_close_html()
	{
		$html = array
		(
			self::CLEAR_ALL,
			'<input name="submit" type="submit" id="submitbutton" value="Submit">',
			'</form>'
		);
		
		return implode( "\n", $html );
	}
	
	
	/**
	 * Build info form HTML
	 *
	 * @author Dennis Slade
	 * @todo Add option to not show explanations
	 * @todo Add a summary of the results
	 * @todo Add option to show just a summary instead of individual question results
	 * @todo Add formatting options
	 */
	public static function get_info_form()
	{
		$html = array();
		
		$entries = $GLOBALS['KWIZZY_INFO_FORM'];
		$index   = 1;
		
		/**
		 * Loop through each entry to build the info form
		 */
		foreach( $entries as $entry )
		{
			$label           = $entry[ self::LABEL ];
			$input_type      = $entry[ self::INPUT_TYPE ];
			$entry_class     = 'kwizzy_info_form';
			$name            = "info_form_{$index}";
			$id              = "{$name}_{$key}";
			$previous_answer = (isset( $_POST[ $name ] )) ? $_POST[ $name ] : "";
			
			/**
			 * Special formatting if we're this question was required but wasn't answered
			 */
			
			$validation = (isset( $entry[ self::VALIDATION ] )) ? $entry[ self::VALIDATION ] : "";
			
			if ($validation == Kwizzy::REQUIRED
			    && !empty( $_POST )
			    && $previous_answer === "")
			{
				$entry_class .= ' kwizzy_error';
			}
			
			/**
			 * If this entry must be filled in then put that in the HTML
			 */
			$required = (isset( $entry[ self::VALIDATION ] ) && $entry[ self::VALIDATION ] == self::REQUIRED )
	                       ? ' required'
	                       : "";

			$html[] = "<div class=\"$entry_class\">";
			$html[] = "\t<label for=\"$id\">$label</label>";
			$html[] = "\t<input type=\"$input_type\" name=\"$name\" value=\"{$previous_answer}\" id=\"$id\"$required>";
			$html[] = "</div>";
				
			$index++;
		}
		
		return implode( "\n", $html );
	}
	
	
	/**
	 * Build confirmation/results HTML to be shown in the results file
	 *
	 * @author Dennis Slade
	 * @todo Add option to not show explanations
	 * @todo Add a summary of the results
	 * @todo Add option to show just a summary instead of individual question results
	 * @todo Add formatting options
	 */
	public static function get_results()
	{
		$html = array
		(
			'<div class="kwizzy_results">',
			self::CLEAR_ALL
		);
			
		$entries = $GLOBALS['KWIZZY_CONTENT'];
		
		/**
		 * Loop through each question and answer to build the results text
		 */
		foreach( $entries as $i => $entry )
		{
			if (!isset( $entry[ self::QUESTION ] ))
				continue;
			
			$index      = $i + 1;
			$answer_key = "answer_{$index}";
			
			$question = $entry[ self::QUESTION ];
			$answers  = (isset( $entry[ self::ANSWERS ] ))
			               ? $entry[ self::ANSWERS ]
			               : array();
			
			$user_answer  = (isset( $_POST[ $answer_key ] ))
			               ? $_POST[ $answer_key ]
			               : "";
			
			$explanation = (isset( $answers[ $user_answer ] ))
			                  ? $answers[ $user_answer ]
			                  : "n/a";
			
			$html[] = "<div class=\"kwizzy_entry_bullet\">{$index}.</div>";
			$html[] = "<div class=\"kwizzy_entry\">";
			$html[] = "\t<div class=\"kwizzy_question\">$question</div>";
			$html[] = "\t<div class=\"kwizzy_user_answer\">You answered: <span class=\"kwizzy_answer\">$user_answer</span></div>";
			$html[] = "\tWhat it means: <div class=\"kwizzy_explanation\">$explanation</div>";
			$html[] = "</div>";
		}
		
		return implode( "\n", $html );
	}
	
	
	/**
	 * Get the results URI specified in the options file
	 *
	 * @author Dennis Slade
	 */
	public static function get_results_uri()
	{
		$results_uri = $GLOBALS['RESULTS_URI'];
		
		if ($results_uri && !empty( $_POST ))
			return $results_uri;
		
		return FALSE;
	}

	
	/**
	 * Add email to the 3rd party mailing list site.
	 * Currently works only for MailChimp.
	 *
	 * @author Dennis Slade
	 * @todo Refactor using adapters to allow for other 3rd mailing list sites (not just MailChimp)
	 */
	public static function add_user_to_mailing_list()
	{
		$log_prefix = '['.__FUNCTION__.']';
		$ret        = FALSE;
		
		/**
		 * Setup to send to MailChimp
		 */
		
		include_once 'mcapi/MCAPI.class.php';
		include_once 'mcapi/config.inc.php'; //contains apikey
		
		$list_url  = self::extract_value( $GLOBALS, 'MAILING_LIST_URL' );
		$list_user = self::extract_value( $GLOBALS, 'MAILING_LIST_USER' );
		$list_id   = self::extract_value( $GLOBALS, 'MAILING_LIST_ID' );
		$name      = self::extract_value( $_POST, 'info_form_1' );
		$email     = self::extract_value( $_POST, 'info_form_2' );
		
		if (empty( $email ))
		{
			error_log( "** INFO ** $log_prefix No email address, skipping..." );
		}
		elseif (empty( $list_url ))
		{
			error_log( "** INFO ** $log_prefix No mailing list URL, skipping..." );
		}
		else
		{
			/**
			 * We've got an email address and a list URL! Let's do it...
			 */
			
			$api = new MCAPI( $apikey );
			
			$merge_vars = array( 'FNAME' => $name );
			
			/**
			 * By default this sends a confirmation email - you will not see new members
			 * until the link contained in it is clicked!
			 */
			$retval = $api->listSubscribe( $listId, $email, $merge_vars );
			
			if ($api->errorCode)
			{
				/**
				 * We got an error. Log that:
				 */
				error_log( "** ERROR ** $log_prefix Subscription UNsuccessful - Unable to load listSubscribe()!" );
				error_log( "** ERROR ** $log_prefix \tCode=" . $api->errorCode."\n" );
				error_log( "** ERROR ** $log_prefix \tMsg=" . $api->errorMessage."\n" );
			}
			else
			{
				/**
				 * Log that we successfully submitted the email address to the mailing list:
				 */
				error_log( "** INFO ** $log_prefix Subscription successful." );
				$ret = TRUE;
			}
		}
		
		return $ret;
	}
	
	
	/**
	 * Validate form input
	 *
	 * @author Dennis Slade
	 */
	public static function validate_input()
	{
		$entries = $GLOBALS['KWIZZY_CONTENT'];
		$index   = 1;
		
		foreach( $entries as $entry )
		{
			$name            = "answer_{$index}";
			$previous_answer = (isset( $_POST[ $name ] )) ? $_POST[ $name ] : "";
			
			$validation = (isset( $entry[ self::VALIDATION ] )) ? $entry[ self::VALIDATION ] : "";
			
			if ($validation == Kwizzy::REQUIRED
			    && !empty( $_POST )
			    && $previous_answer === "")
			{
				return FALSE;
			}
			
			$index++;
		}
		
		return TRUE;
	}
	
	
	/**
	 * Safely extracts any named value from a hash table
	 *
	 * @author Dennis Slade
	 * @param Mixed $hash
	 * @param Mixed $value
	 * @param Mixed $default
	 * @param Mixed $default_if_in
	 */
	public static function extract_value( $hash, $value, $default="", array $default_if_in = NULL )
	{
		if (!isset( $hash[$value] )
		    || ((!empty($default_if_in) && (in_array($hash[$value],$default_if_in,TRUE) ))))
		{
			return $default;
		}
		
		return $hash[$value];
	}
	
}


/* End of file kwizzy.class.php */
