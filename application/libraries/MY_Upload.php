<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * File Uploading Class
 *
 * @category	Uploads
 * @author		Adam (Pastel Dev Team)
 * subclassed from CI_Upload to handle multiple file upload (array)
 *
 */

class MY_Upload extends CI_Upload {
	public $file_index				= null;
	
	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct($props = array())
	{
        parent::__construct($props);
		if (count($props) > 0)
		{
			$this->initialize($props);
		}

		log_message('debug', "Upload Class Initialized");
	}


	/**
	 * Initialize preferences
	 *
	 * @param	array
	 * @return	void
	 */
	public function initialize($config = array())
	{
		$defaults = array(
							'max_size'			=> 0,
							'max_width'			=> 0,
							'max_height'		=> 0,
							'max_filename'		=> 0,
							'allowed_types'		=> "",
							'file_temp'			=> "",
							'file_name'			=> "",
							'orig_name'			=> "",
							'file_type'			=> "",
							'file_size'			=> "",
							'file_ext'			=> "",
							'upload_path'		=> "",
							'overwrite'			=> FALSE,
							'encrypt_name'		=> FALSE,
							'is_image'			=> FALSE,
							'image_width'		=> '',
							'image_height'		=> '',
							'image_type'		=> '',
							'image_size_str'	=> '',
							'error_msg'			=> array(),
							'mimes'				=> array(),
							'remove_spaces'		=> TRUE,
							'xss_clean'			=> FALSE,
							'temp_prefix'		=> "temp_file_",
							'client_name'		=> '',
							'file_index'		=> 0
						);


		foreach ($defaults as $key => $val)
		{
			if (isset($config[$key]))
			{
				$method = 'set_'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($config[$key]);
				}
				else
				{
					$this->$key = $config[$key];
				}
			}
			else
			{
				$this->$key = $val;
			}
		}

		// if a file_name was provided in the config, use it instead of the user input
		// supplied file name for all uploads until initialized again
		$this->_file_name_override = $this->file_name;
	}

	/**
	 * Perform the file upload
	 *
	 * @return	bool
	 */
	public function do_upload($field = 'userfile')
	{

		// Is $_FILES[$field] set? If not, no reason to continue.
		if ( ! isset($_FILES[$field]))
		{
			$this->set_error('upload_no_file_selected');
			return FALSE;
		}

		if ( ! isset($this->file_index) || $this->file_index == null)
		{
			if (is_array($_FILES[$field]['tmp_name'])) {
				$this->file_index = 0;
			}
		}
		
		if (!is_array($_FILES[$field]['tmp_name'])) {
			return parent::do_upload($field);
		}
		else {
			// Is the upload path valid?
			if ( ! $this->validate_upload_path())
			{
				// errors will already be set by validate_upload_path() so just return FALSE
				return FALSE;
			}

			// Was the file able to be uploaded? If not, determine the reason why.
			if ( ! is_uploaded_file($_FILES[$field]['tmp_name'][$this->file_index]))
			{
				$error = ( ! isset($_FILES[$field]['error'][$this->file_index])) ? 4 : $_FILES[$field]['error'][$this->file_index];

				switch($error)
				{
					case 1:	// UPLOAD_ERR_INI_SIZE
						$this->set_error('upload_file_exceeds_limit');
						break;
					case 2: // UPLOAD_ERR_FORM_SIZE
						$this->set_error('upload_file_exceeds_form_limit');
						break;
					case 3: // UPLOAD_ERR_PARTIAL
						$this->set_error('upload_file_partial');
						break;
					case 4: // UPLOAD_ERR_NO_FILE
						$this->set_error('upload_no_file_selected');
						break;
					case 6: // UPLOAD_ERR_NO_TMP_DIR
						$this->set_error('upload_no_temp_directory');
						break;
					case 7: // UPLOAD_ERR_CANT_WRITE
						$this->set_error('upload_unable_to_write_file');
						break;
					case 8: // UPLOAD_ERR_EXTENSION
						$this->set_error('upload_stopped_by_extension');
						break;
					default :   $this->set_error('upload_no_file_selected');
						break;
				}

				return FALSE;
			}

			// Set the uploaded data as class variables
			$this->file_temp = $_FILES[$field]['tmp_name'][$this->file_index];
			$this->file_size = $_FILES[$field]['size'][$this->file_index];
			$this->_file_mime_type($_FILES[$field]);
			$this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $this->file_type);
			$this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
			$this->file_name = $this->_prep_filename($_FILES[$field]['name'][$this->file_index]);
			$this->file_ext	 = $this->get_extension($this->file_name);
			$this->client_name = $this->file_name;

			// Is the file type allowed to be uploaded?
			if ( ! $this->is_allowed_filetype())
			{
				$this->set_error('upload_invalid_filetype');
				return FALSE;
			}

			// if we're overriding, let's now make sure the new name and type is allowed
			if ($this->_file_name_override != '')
			{
				$this->file_name = $this->_prep_filename($this->_file_name_override);

				// If no extension was provided in the file_name config item, use the uploaded one
				if (strpos($this->_file_name_override, '.') === FALSE)
				{
					$this->file_name .= $this->file_ext;
				}

				// An extension was provided, lets have it!
				else
				{
					$this->file_ext	 = $this->get_extension($this->_file_name_override);
				}

				if ( ! $this->is_allowed_filetype(TRUE))
				{
					$this->set_error('upload_invalid_filetype');
					return FALSE;
				}
			}

			// Convert the file size to kilobytes
			if ($this->file_size > 0)
			{
				$this->file_size = round($this->file_size/1024, 2);
			}

			// Is the file size within the allowed maximum?
			if ( ! $this->is_allowed_filesize())
			{
				$this->set_error('upload_invalid_filesize');
				return FALSE;
			}

			// Are the image dimensions within the allowed size?
			// Note: This can fail if the server has an open_basdir restriction.
			if ( ! $this->is_allowed_dimensions())
			{
				$this->set_error('upload_invalid_dimensions');
				return FALSE;
			}

			// Sanitize the file name for security
			$this->file_name = $this->clean_file_name($this->file_name);

			// Truncate the file name if it's too long
			if ($this->max_filename > 0)
			{
				$this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
			}

			// Remove white spaces in the name
			if ($this->remove_spaces == TRUE)
			{
				$this->file_name = preg_replace("/\s+/", "_", $this->file_name);
			}

			/*
			 * Validate the file name
			 * This function appends an number onto the end of
			 * the file if one with the same name already exists.
			 * If it returns false there was a problem.
			 */
			$this->orig_name = $this->file_name;

			if ($this->overwrite == FALSE)
			{
				$this->file_name = $this->set_filename($this->upload_path, $this->file_name);

				if ($this->file_name === FALSE)
				{
					return FALSE;
				}
			}

			/*
			 * Run the file through the XSS hacking filter
			 * This helps prevent malicious code from being
			 * embedded within a file.  Scripts can easily
			 * be disguised as images or other file types.
			 */
			if ($this->xss_clean)
			{
				if ($this->do_xss_clean() === FALSE)
				{
					$this->set_error('upload_unable_to_write_file');
					return FALSE;
				}
			}

			/*
			 * Move the file to the final destination
			 * To deal with different server configurations
			 * we'll attempt to use copy() first.  If that fails
			 * we'll use move_uploaded_file().  One of the two should
			 * reliably work in most environments
			 */
			if ( ! @copy($this->file_temp, $this->upload_path.$this->file_name))
			{
				if ( ! @move_uploaded_file($this->file_temp, $this->upload_path.$this->file_name))
				{
					$this->set_error('upload_destination_error');
					return FALSE;
				}
			}

			/*
			 * Set the finalized image dimensions
			 * This sets the image width/height (assuming the
			 * file was an image).  We use this information
			 * in the "data" function.
			 */
			$this->set_image_properties($this->upload_path.$this->file_name);

			return TRUE;
		}
	}

	/**
	 * File MIME type
	 *
	 * Detects the (actual) MIME type of the uploaded file, if possible.
	 * The input array is expected to be $_FILES[$field]
	 *
	 * @param	array
	 * @return	void
	 */
	protected function _file_mime_type($file)
	{
		if (!is_array($file['tmp_name'])) {
			parent::_file_mime_type($file);
		}
		else {
			// We'll need this to validate the MIME info string (e.g. text/plain; charset=us-ascii)
			$regexp = '/^([a-z\-]+\/[a-z0-9\-\.\+]+)(;\s.+)?$/';

			/* Fileinfo extension - most reliable method
			 *
			 * Unfortunately, prior to PHP 5.3 - it's only available as a PECL extension and the
			 * more convenient FILEINFO_MIME_TYPE flag doesn't exist.
			 */
			if (function_exists('finfo_file'))
			{
				$finfo = finfo_open(FILEINFO_MIME);
				if (is_resource($finfo)) // It is possible that a FALSE value is returned, if there is no magic MIME database file found on the system
				{
					$mime = @finfo_file($finfo, $file['tmp_name'][$this->file_index]);
					finfo_close($finfo);

					/* According to the comments section of the PHP manual page,
					 * it is possible that this function returns an empty string
					 * for some files (e.g. if they don't exist in the magic MIME database)
					 */
					if (is_string($mime) && preg_match($regexp, $mime, $matches))
					{
						$this->file_type = $matches[1];
						return;
					}
				}
			}

			/* This is an ugly hack, but UNIX-type systems provide a "native" way to detect the file type,
			 * which is still more secure than depending on the value of $_FILES[$field]['type'], and as it
			 * was reported in issue #750 (https://github.com/EllisLab/CodeIgniter/issues/750) - it's better
			 * than mime_content_type() as well, hence the attempts to try calling the command line with
			 * three different functions.
			 *
			 * Notes:
			 *	- the DIRECTORY_SEPARATOR comparison ensures that we're not on a Windows system
			 *	- many system admins would disable the exec(), shell_exec(), popen() and similar functions
			 *	  due to security concerns, hence the function_exists() checks
			 */
			if (DIRECTORY_SEPARATOR !== '\\')
			{
				$cmd = 'file --brief --mime ' . escapeshellarg($file['tmp_name'][$this->file_index]) . ' 2>&1';

				if (function_exists('exec'))
				{
					/* This might look confusing, as $mime is being populated with all of the output when set in the second parameter.
					 * However, we only neeed the last line, which is the actual return value of exec(), and as such - it overwrites
					 * anything that could already be set for $mime previously. This effectively makes the second parameter a dummy
					 * value, which is only put to allow us to get the return status code.
					 */
					$mime = @exec($cmd, $mime, $return_status);
					if ($return_status === 0 && is_string($mime) && preg_match($regexp, $mime, $matches))
					{
						$this->file_type = $matches[1];
						return;
					}
				}

				if ( (bool) @ini_get('safe_mode') === FALSE && function_exists('shell_exec'))
				{
					$mime = @shell_exec($cmd);
					if (strlen($mime) > 0)
					{
						$mime = explode("\n", trim($mime));
						if (preg_match($regexp, $mime[(count($mime) - 1)], $matches))
						{
							$this->file_type = $matches[1];
							return;
						}
					}
				}

				if (function_exists('popen'))
				{
					$proc = @popen($cmd, 'r');
					if (is_resource($proc))
					{
						$mime = @fread($proc, 512);
						@pclose($proc);
						if ($mime !== FALSE)
						{
							$mime = explode("\n", trim($mime));
							if (preg_match($regexp, $mime[(count($mime) - 1)], $matches))
							{
								$this->file_type = $matches[1];
								return;
							}
						}
					}
				}
			}

			// Fall back to the deprecated mime_content_type(), if available (still better than $_FILES[$field]['type'])
			if (function_exists('mime_content_type'))
			{
				$this->file_type = @mime_content_type($file['tmp_name'][$this->file_index]);
				if (strlen($this->file_type) > 0) // It's possible that mime_content_type() returns FALSE or an empty string
				{
					return;
				}
			}

			$this->file_type = $file['type'][$this->file_index];
		}
	}


	/**
	 * Set File Index
	 *
	 * Enables the XSS flag so that the file that was uploaded
	 * will be run through the XSS filter.
	 *
	 * @param	bool
	 * @return	void
	 */
	public function set_file_index($index = 0)
	{
		$this->file_index = $index;
	}
	

	/**
	 * Get File Num
	 *
	 * Return array's size
	 *
	 * @param	string 
	 * @return	int
	 */
	public function get_file_num($field) {
		if (is_array($_FILES[$field]['tmp_name'])) {
			return sizeof($_FILES[$field]['tmp_name']);
		}
		return 0;
	}
	

	/**
	 * Get Orig Name
	 *
	 * Return file's orig name
	 *
	 * @param	string 
	 * @param	int 
	 * @return	string
	 */
	public function get_orig_name($field,$index) {
		if (is_array($_FILES[$field]['name'])) {
			return $_FILES[$field]['name'][$index];
		}
		return $_FILES[$field]['name'];
	}
}
?>