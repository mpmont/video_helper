<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * MarcoMonteiro Video Helper
 *
 * Serdar Senay (Lupelius)
 * Fix applied where all methods had unnecessary if checks for checking
 * valid ID, removed those as youtube|vimeo_id functions already check that
 * Also added vimeo to _isValidID check, and added vimeo_fullvideo method
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Marco Monteiro
 * @link			www.marcomonteiro.net
 * @version 	1.0.5
 */

// ------------------------------------------------------------------------

/**
 * Get Youtube Id
 *
 * @access	public
 * @param	string	Youtube url
 * @return	string	Youtube ID
 */
if ( ! function_exists('youtube_id'))
{
	function youtube_id( $url = '')
	{
		if ( $url === '' )
		{
			return FALSE;
		}
		if (!_isValidURL( $url ))
		{
			return FALSE;
		}

		preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);

		if(!$matches){
			return FALSE;
		}

		if ( !_isValidID( $matches[0] ))
		{
			return FALSE;
		}
		else{
			return $matches[0];
		}
	}
}


/**
 * Get Vimeo Id
 *
 * @access	public
 * @param	string	Vimeo url
 * @return	string	Vimeo ID
 */
if ( ! function_exists('vimeo_id'))
{
	function vimeo_id( $url = '')
	{
		if ( $url === '' )
		{
			return FALSE;
		}
		if (_isValidURL( $url ))
		{
			sscanf(parse_url($url, PHP_URL_PATH), '/%d', $vimeo_id);
		}
		else {
			$vimeo_id = $url;
		}

		return (_isValidID($vimeo_id,TRUE)) ? $vimeo_id : FALSE;
	}
}

/**
 *Get youtube video page
 *
 * @access	public
 * @param	string	Youtube url || Youtube id
 * @return	$array	url's video
 */
 if ( ! function_exists('youtube_fullvideo'))
 {
 	function youtube_fullvideo( $url_id = '' )
 	{
 		if ( $url_id == '' )
		{
			return FALSE;
		}
		if ( _isValidID( $url_id ) )
		{
			$id = $url_id;
		}
		else{
			$id = youtube_id( $url_id );
		}
		return 'http://www.youtube.com/v/'.$id;
 	}
 }

 /**
 *Get vimeo video page
 *
 * @access	public
 * @param	string	Vimeo ID
 * @return	$array	url's video
 */
 if ( ! function_exists('vimeo_fullvideo'))
 {
 	function vimeo_fullvideo( $url_id = '' )
 	{
 		if ( $url_id == '' )
		{
			return FALSE;
		}
		if ( _isValidID( $url_id ) )
		{
			$id = $url_id;
		}
		else{
			$id = vimeo_id( $url_id );
		}
		return ($id) ? 'http://vimeo.com/'.$id : FALSE;
 	}
 }

/**
 * Get Youtube thumbs
 *
 * @access	public
 * @param	string	Youtube url || Youtube id
 * @param 	number	1 to 4 to return a specific thumb
 * @return	array		url's to thumbs or specific thumb
 */
if ( ! function_exists('youtube_thumbs'))
{
	function youtube_thumbs( $url_id = '', $thumb = '')
	{
		if ( $url_id === '' )
		{
			return FALSE;
		}
		if ($thumb > 4 || $thumb < 1)
		{
			return FALSE;
		}
		if ( _isValidID( $url_id ) )
		{
			$id = $url_id;
		}
		else{
			$id = youtube_id( $url_id );
		}

		$result = array(
			'0' => 'http://img.youtube.com/vi/'.$id.'/0.jpg',
			'1' => 'http://img.youtube.com/vi/'.$id.'/1.jpg',
			'2' => 'http://img.youtube.com/vi/'.$id.'/2.jpg',
			'3' => 'http://img.youtube.com/vi/'.$id.'/3.jpg'
		);

		if ( $thumb == '' ){
			return $result;
		}
		else
		{
			return $result[$thumb];
		}
	}
}



/**
 * Get Vimeo thumbs
 *
 * @access	public
 * @param	string		Vimeo url || Vimeo id
 * @param 	number 		1 to 3 to return a specific thumb
 * @return	array 		url's to thumbs or specific thumb
 */
if ( ! function_exists('vimeo_thumbs'))
{
	function vimeo_thumbs( $url_id = '', $thumb = '')
	{
		if ( $url_id == '' )
		{
			return FALSE;
		}
		if ( $thumb < 1 || $thumb > 3 )
		{
			return FALSE;
		}
		if ( !_isValidURL( $url_id ) )
		{
			$id = $url_id;
		}
		else{
			$id = vimeo_id( $url_id );
		}

		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));

		$result = array(
			'0' => $hash[0]['thumbnail_small'],
			'1' => $hash[0]['thumbnail_medium'],
			'2' => $hash[0]['thumbnail_large']
		);

 		if ( $thumb == '' ){
			return $result;
		}
		else
		{
			return $result[$thumb];
		}

	}
}



/**
 * Get Youtube embed
 *
 * @access	public
 * @param	string		Youtube url || Youtube id
 * @param 	number 		width
 * @param   number 		height
 * @param   boolean 		old embed / default = FALSE
 * @param   boolean 		HD / default = FALSE / The width and height will not be used if passed
 * @param   boolean 		https / default = FALSE
 * @param   boolean 		suggested videos / default = FALSE
 * @return	string   	embebed code
 */

if ( ! function_exists('youtube_embed'))
{
	function youtube_embed( $url_id = '', $width = '', $height = '',
	$old_embed = FALSE, $hd = FALSE, $https = FALSE, $suggested = FALSE)
	{
		if ( $url_id == '' )
		{
			return FALSE;
		}

		if ( _isValidID( $url_id ) )
		{
			$id = $url_id;
		}
		else{
			$id = youtube_id( $url_id );
		}

		//Contruct the old embed code
		if ( $old_embed )
		{
			if ( $hd )
			{
				$embed = '<object width="1280" height="720">';
			}
			else
			{
				$embed = '<object width="'.$width.'" height="'.$height.'">';
			}
			$embed .= '<param name="movie" value="';
			if( $https )
			{
				$embed .= 'https';
			}
			else{
				$embed .= 'http';
			}
			$embed .= '://www.youtube-nocookie.com/v/'.$id.'?version=3&amp;hl=en_US&amp;';
			if ( $suggested )
			{
				$embed .= 'rel=0&amp;';
			}
			if ( $hd )
			{
				$embed .= 'hd=1';
			}
			$embed .= '"></param>';
			$embed .= '<param name="allowFullScreen" value="true"></param>';
			$embed .= '<param name="allowscriptaccess" value="always"></param>';
			$embed .= '<embed src="';
			if( $https )
			{
				$embed .= 'https';
			}
			else
			{
				$embed .= 'http';
			}
			$embed .= '://www.youtube-nocookie.com/v/'.$id.'?version=3&amp;hl=en_US';
			if ( $hd )
			{
				$embed .= '&amp;hd=1';
			}
			$embed .= '" type="application/x-shockwave-flash" ';
			if ( $hd )
			{
				$embed .= 'width="1280" height="720" ';
			}
			else
			{
				$embed .= 'width="'.$width.'" height="'.$height.'" ';
			}
			$embed .= 'allowscriptaccess="always" allowfullscreen="true"></embed>';
			$embed .= '</object>';
		}
		//Contruct the new embed code
		else
		{
			$embed = '<iframe ';
			if ( $hd )
			{
				$embed .= 'width="1280" height="720" ';
			}
			else
			{
				$embed .= 'width="'.$width.'" height="'.$height.'" ';
			}
			$embed .= 'src="';
			if ( $https )
			{
				$embed .= 'https';
			}
			else
			{
				$embed .= 'http';
			}
			$embed .= '://www.youtube-nocookie.com/embed/'.$id;
			if ( $suggested OR $hd )
			{
				$embed .= '?';
			}
			if ( $suggested )
			{
				$embed .= 'rel=0&amp;';
			}
			if ( $hd )
			{
				$embed .= 'hd=1';
			}
			$embed .= '" frameborder="0" allowfullscreen></iframe>';
		}
		return $embed;
	}
}



/**
 * Get Vimeo embed
 *
 * @access	public
 * @param	string		Vimeo url || Vimeo id
 * @param 	number 		width
 * @param   number 		height
 * @param   boolean 		color
 * @param   boolean 		autoplay / default = FALSE
 * @param   boolean 		https / default = FALSE
 * @return	string   	embebed code
 */

if ( ! function_exists('vimeo_embed'))
{
	function vimeo_embed( $url_id = '', $width = '', $height = '',
	$color = '', $title = FALSE, $autoplay = FALSE, $https = FALSE)
	{
		if ( $url_id == '' )
		{
			return FALSE;
		}
		if ( !_isValidURL( $url_id ) )
		{
			$id = $url_id;
		}
		else
		{
			$id = vimeo_id( $url_id );
		}

		$embed = '<iframe src="';
		if ( $https )
		{
			$embed .= 'https';
		}
		else
		{
			$embed .= 'http';
		}

		$embed .= '://player.vimeo.com/video/'.$id.'?byline=0&amp;portrait=0&amp;';
		if ( $color != '' )
		{
			$embed .= 'color='.$color.'&amp;';
		}
		if ( $autoplay )
		{
			$embed .= 'autoplay=1';
		}
		$embed .= '" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';

		return $embed;
	}
}


/**
 * Validate URL
 * This URL could have http or just www
 *
 * @access private
 * @param string 		Youtube URL
 * @return preg_match
 */
if ( ! function_exists('_isValidURL'))
{
	function _isValidURL($url = '')
	{
		return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/i', $url);
	}
}


/**
 * Validate ID
 * Check if the id is valid or not
 *
 * @access private
 * @param string 		Youtube ID OR Vimeo ID
 * @return boolean
 */
if ( ! function_exists('_isValidID'))
{
	function _isValidID($id = '', $vimeo=FALSE)
	{
		if ($vimeo)
			$headers = get_headers('http://vimeo.com/' . $id);
		else
			$headers = get_headers('http://gdata.youtube.com/feeds/api/videos/' . $id);
		if (!strpos($headers[0], '200'))
		{
		    return FALSE;
		}
		else{
			return TRUE;
		}
	}
}

// ------------------------------------------------------------------------

/* End of file video_helper.php */
/* Location: ./application/helpers/video_helper.php */