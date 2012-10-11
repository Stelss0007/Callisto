<?php

/**
 * Helper function for smarty_cache_xcache()
 * Checks whether a cached content has been expired by reading the content's header.
 *
 * @access  private
 * @param   string    $cache_content      the cached content
 * @return  boolean                       TRUE if cache has been expired, FALSE otherwise
 *
 * @see     smarty_cache_xcache()
 */
function _xcache_hasexpired(&$cache_content)
	{
	$split = explode("\n", $cache_content, 2);
	$attributes = unserialize($split[0]);
	if ($attributes['expires'] > 0 && time() > $attributes['expires'])
		return true;
	else
		return false;
	}

/**
 * Smarty Cache Handler<br>
 * utilizing xcache extension (http://xcache.net/)<br>
 *
 * Name:     smarty_cache_xcache<br>
 * Type:     Cache Handler<br>
 * Purpose:  Replacement for the file based cache handling of Smarty. smarty_cache_xcache() is
 *           using Turck xcache extension to minimize disk usage.
 * File:     cache.xcache.php<br>
 * Date:     Dec 2, 2003<br>
 *
 * Usage Example<br>
 * <pre>
 * $smarty = new Smarty;
 * $smarty->cache_handler_func = 'smarty_cache_xcache';
 * $smarty->caching = true;
 * $smarty->display('index.tpl');
 * </pre>
 *
 * @author   Ilya Berdinskikh
 *
 * @param    string   $action         Cache operation to perform ( read | write | clear )
 * @param    mixed    $smarty         Reference to an instance of Smarty
 * @param    string   $cache_content  Reference to cached contents
 * @param    string   $tpl_file       Template file name
 * @param    string   $cache_id       Cache identifier
 * @param    string   $compile_id     Compile identifier
 * @param    integer  $exp_time       Expiration time
 * @return   boolean                  TRUE on success, FALSE otherwise
 *
 * @link     http://xcache.net/
 *           (xcache homepage)
 * @link     http://smarty.net/manual/en/section.template.cache.handler.func.php
 *           (Smarty online manual)
 */
function smarty_cache_xcache($action, &$smarty, &$cache_content, $tpl_file=null, $cache_id=null, $compile_id=null, $exp_time=null)
	{
	if (!function_exists("xcache_set"))
		{
		$smarty->trigger_error("cache_handler: PHP Extension \"xcache\" (http://xcache.net/HomeUk) not installed.");
		return false;
		}

	// Create unique cache id:
	// $xcache_id  = 'smarty|'.$cache_id.'_'.$tpl_file;
	$xcache_id = 'smarty|' . $cache_id;

	switch ($action)
		{
		case 'read':
			// read cache from shared memory
			$cache_content = @gzuncompress(xcache_get($xcache_id));
			if (!is_null($cache_content) && _xcache_hasexpired($cache_content))
				{
				// Cache has been expired so we clear it now by calling ourself with another parameter :)
				$cache_content = null;
				}

			$return = true;
			break;

		case 'write':
			// save cache to shared memory
			$current_time = time();
			//Почемуто не корректно передается $exp_time
			$exp_time = $current_time + $smarty->cache_lifetime;

			if (is_null($exp_time) || $exp_time < $current_time)
				{
				global $sysConfig;
				$ttl = $sysConfig['systpl.cache_lifetime'];
				}
			else
				$ttl = $exp_time - $current_time;

			//Ложим инфу в xcache
			$return = xcache_set($xcache_id, gzcompress($cache_content, 8), $ttl);
			break;

		case 'clear':
			// clear cache info
			$return = xcache_unset_by_prefix($xcache_id);
			break;

		default:
			// error, unknown action
			$smarty->trigger_error("cache_handler: unknown action \"$action\"");
			$return = false;
			break;
		}
	return $return;
	}

?>
