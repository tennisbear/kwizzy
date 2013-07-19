<?php
/**
 * Class for executing and processing cURL calls
 *
 * @author Dennis Slade
 * @since  2012-07-29
 */

class Curl
{
	const STATUS_CONTINUE = 100;
	const STATUS_OK       = 200;
	const STATUS_CREATED  = 201;
	const STATUS_ERROR    = 500;

	const BODY            = 'Body';
	const STATUS          = 'Status';
	
	private $text   = "";
	private $data   = NULL;
	private $status = self::STATUS_OK;
	
	
    public function __construct()
    {
    }
    
    
    /**
     * Do a cURL post against a given URL
     *
     * @author Dennis Slade
     * @param String $url
     * @param String $content
     * @param String $content_type
     */
	public static function post( $url, $content, $content_type = "" )
	{
		if (($handle = curl_init( $url )) === FALSE)
			return FALSE;
		
		curl_setopt( $handle, CURLOPT_URL, $url ); /* *** */
		curl_setopt( $handle, CURLOPT_POSTFIELDS, $content );
		curl_setopt( $handle, CURLOPT_POST, TRUE );
		curl_setopt( $handle, CURLOPT_HEADER, TRUE );
		
		if ($content_type)
		{
			curl_setopt( $handle, CURLOPT_HTTPHEADER, array( "Content-Type: $content_type",
			                                                 "Content-Length: 0" ));
		}
		
		ob_start();
		$status = curl_exec( $handle );
		curl_close( $handle );
		$response = ob_get_contents();
		ob_end_clean();
		
		/**
		 * Return the response (parsed for ease of use outside this method)
		 */
		return self::parse_http_response( $response );
	}
	
	
	/**
     * Do a cURL post against a URL with cookie-based authentication. First
     * the URL is hit to get the cookie, then that cookie is cURL posted along
     * with our data to the destination URL. (This was a security restriction
     * to do posts against certain RightScale servers.)
     *
	 * @author Dennis Slade
     * @param String $cookie_url
	 * @param String $userpw_credentials
	 * @param String $post_url
	 * @param String $post_fields
	 * @param String $extra_headers
	 */
	public static function post_with_cookie( $cookie_url, $userpw_credentials, $post_url, $post_fields, $extra_headers = "" )
	{
		if (($handle = curl_init( $cookie_url )) === FALSE)
			return FALSE;

		$log_prefix = "[".__FUNCTION__."]";
		
		/**
		 * Temporary cookie info will be stored here
		 */
		$cookie_jar_file = tempnam( "/tmp", "rsAPICookie" );
		
		/**
		 * Prep for curl...
		 */
		curl_setopt( $handle, CURLOPT_COOKIEJAR, $cookie_jar_file );
		curl_setopt( $handle, CURLOPT_USERPWD, $userpw_credentials );
		curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, TRUE );
		
		/**
		 * Curl the cookie
		 */
		
		ob_start();
		$status = curl_exec( $handle );
		$sresponse = ob_get_contents();
		ob_end_clean();
		
		if ($errno = curl_errno( $handle ))
		{
			error_log( "[INFO]$log_prefix Cookie retrieval errno = $errno" );
			error_log( "[INFO]$log_prefix Response = \n$response" );
			return FALSE;
		}
		
		/**
		 * Prep for next curl...
		 */
		
		curl_setopt( $handle, CURLOPT_URL, $post_url );
		
    	curl_setopt( $handle, CURLOPT_USERPWD, FALSE );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, FALSE );
		curl_setopt( $handle, CURLOPT_POST, TRUE );
		curl_setopt( $handle, CURLOPT_HEADER, TRUE );
		curl_setopt( $handle, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt( $handle, CURLOPT_VERBOSE, TRUE);
		
    	curl_setopt( $handle, CURLOPT_COOKIEFILE, $cookie_jar_file );
		curl_setopt( $handle, CURLOPT_HTTPHEADER, $extra_headers );
		curl_setopt( $handle, CURLOPT_POSTFIELDS, $post_fields );
		
		/**
		 * Curl the post
		 */
		
		ob_start();
		$status = curl_exec( $handle );
		$errno = curl_errno( $handle );
		
		curl_close( $handle );
		$response = ob_get_contents();
		ob_end_clean();
		
		/**
		 * Put something in the log and return FALSE if we had an error
		 */
		if ($errno)
		{
			error_log( "[INFO]$log_prefix Exec errno = $errno" );
			error_log( "[INFO]$log_prefix Response = \n$response" );
			return FALSE;
		}
		
		/**
		 * Return the response (parsed for ease of use outside this method)
		 */
		return self::parse_http_response( $response );
	}
	
	
	/**
	 * Parse HTTP response text into an associative array
	 *
	 * @author Dennis Slade
     * @param String $response_text
	 */
	public static function parse_http_response( $response_text )
	{
		$response = explode( "\r\n\r\n", $response_text );
		
		/**
		 * First extract the repsonse's header
		 */
		$ret = self::http_header_to_array( $response[0] );
			
		if (!empty( $ret )
		    && isset( $ret[ self::STATUS ] )
		    && ($ret[ self::STATUS ] == self::STATUS_CONTINUE))
		{
			/**
			 * Special case: When we start with return status CONTINUE=100
			 *               then start over using just the rest of the response
			 */
			
			unset( $response[0] );

			$ret = self::parse_http_response( implode( "\r\n\r\n", $response ));
		}
		else
		{
			if (empty( $ret ))
			{
				/**
				 * No header: Set the returning body to be the entire text of the response
				 */
				$ret[ self::BODY ] = $response_text;
			}
			else
			{
				/**
				 * Set the returning body to be the second part of the response
				 */
				$ret[ self::BODY ] = (isset( $response[1] )) ? $response[1] : "";
			}
			
			if (!isset( $ret[ self::STATUS ] ))
			{
				/**
				 * No status: Set default status to OK=200
				 */
				$ret[ self::STATUS ] = self::STATUS_OK;
			}
		}
		
		return $ret;
	}
	
	
	/**
	 * Extract HTTP header text into an associative array
	 *
	 * @author Dennis Slade
     * @param unknown_type $header_text
	 */
	public static function http_header_to_array( $header_text )
	{
		$ret = array();
		
		if ((strncasecmp( $header_text, 'HTTP', 4 ) === 0)
		    || (strstr( $header_text, 'Content-Type: ' ) !== FALSE))
		{
			/**
			 * Getting this far means we've got at least a minimally compliant HTTP response to work with
			 */
			
			$headers = explode( "\r\n", $header_text );
			
			if (!empty( $headers ) && is_array( $headers))
			{
				/**
				 * Yay! We've got headers!
				 */
				
				foreach( $headers as $one_header )
				{
					$one_header = explode( ": ", $one_header );
					
					if (count($one_header) > 1)
					{
						/**
						 * It's a normal header - store the value in the return variable
						 */
						$ret[ $one_header[0] ] = $one_header[1];
					}
					else
					{
						/**
						 * Try to the extract and store the responses' return status
						 */
						
						$one_header = explode( " ", $one_header[0] );
						
						if (isset( $one_header[1] ) && is_numeric( $one_header[1] ))
						{
							$ret[ self::STATUS ] = $one_header[1];
						}
						else
						{
							$ret[ self::STATUS ] = $one_header[0];
						}
					}
				}
			}
		}
		
		return $ret;
	}

	
	/**
	 * UTILITY METHODS
	 */
	
	
	public function get_data()
	{
		return $this->data;
	}
	
	
	public function has_data()
	{
		return isset( $this->data );
	}
	
	
	public function has_errors()
	{
		return (!$this->has_data()
		        || $this->status !== self::STATUS_OK);
	}
	
	
	public static function response_ok( $response )
	{
		return !empty( $response )
		       && is_array( $response )
		       && isset( $response[ self::STATUS ] )
		       && ($response[ self::STATUS ] == self::STATUS_OK);
	}
	
}

/* End of file Curl.php */
