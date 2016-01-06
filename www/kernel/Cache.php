<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cache
 *
 * @author Ruslan
 */
class Cache 
{
    public static function setCached($component, $cacheKey, $value=null, $ttl=null)
        {
        global $appConfig;

        //Empty приводим к false
        if (!isset ($value)) 
            {
            $value = false;
            }

        //Удлиняем $cacheKey
        $cacheKey = $component.'_'.$cacheKey;

        //Складываем ключь в память
        $appConfig[$cacheKey] = $value;

        //В зависимости от типа сохраняем кеш в внешнее хранилище
        if ($appConfig['Var.caching'] == 'disk')
          {
          $cacheKey_crc = (string)abs (crc32 ($cacheKey));
          $dir_way = './cache/vars/' . $component . '/'. $cacheKey_crc[0].'/'.$cacheKey_crc[1].'/';
          if (!file_exists($dir_way)) 
            {  
            mkdir($dir_way, $appConfig['default.dir.perms'], true);
            }

          return (file_put_contents($dir_way.$cacheKey, serialize($value),LOCK_EX));
          }
        elseif ($appConfig['Var.caching'] == 'xcache')
          {
          if (!$ttl) 
            {
            $ttl = $appConfig['Var.cache_lifetime'];
            }
          return (xcache_set('appVar_'.$cacheKey, $value, $ttl));
          }
        elseif ($appConfig['Var.caching'] == 'eaccelerator')
          {
          if (!$ttl) 
            {
            $ttl = $appConfig['Var.cache_lifetime'];
            }
          return (eaccelerator_put('appVar_'.$cacheKey, $value, $ttl));
          }
        elseif ($appConfig['Var.caching'] == 'apc')
          {
          if (!$ttl) 
            {
            $ttl = $appConfig['Var.cache_lifetime'];
            }
          return (apc_store('appVar_'.$cacheKey, $value, $ttl));
          }

        return true;
        }

/**
 * @desc Извликает переменную из кеша
 * @return misc Значение переменной
 * @param component string Модуль к которому относится переменная
 * @param cacheKey string Ключь
 */
    public static function getCached($component, $cacheKey)
        {
        global $appConfig;
        //Удлиняем $cacheKey
        $cacheKey = $component.'_'.$cacheKey;

        //Если есть ключь в памяти - возвращаем из памяти
        if (isset($appConfig[$cacheKey])) 
            {
            return $appConfig['appVar_cache'][$cacheKey];
            }

        //В зависимости от типа загружаем кеш из внешнего хранилища
        if ($appConfig['Var.caching'] == 'disk')
          {
          $cacheKey_crc = (string)abs(crc32($cacheKey));
          $file_way = './cache/vars/' . $component . '/'. $cacheKey_crc[0] . '/' . $cacheKey_crc[1] . '/' . $cacheKey;
          if (file_exists($file_way))
            {  
            $appConfig['appVar_cache'][$cacheKey] = unserialize(file_get_contents($file_way));
            }
          else 
            { 
            return;
            }
          }
        elseif ($appConfig['Var.caching'] == 'xcache')
          {
          $appConfig['appVar_cache'][$cacheKey] = xcache_get('appVar_' . $cacheKey);
          }
        elseif ($appConfig['appConfig']['Var.caching'] == 'eaccelerator')
          {
          $appConfig['appVar_cache'][$cacheKey] = eaccelerator_get('appVar_' . $cacheKey);
          }
        elseif ($appConfig['Var.caching'] == 'apc')
          {
          $apc_value = apc_fetch('appVar_' . $cacheKey, $success);
          if ($success) 
            {
            $appConfig['appVar_cache'][$cacheKey] = $apc_value;
            }
          }

        if (isset($appConfig['appVar_cache'][$cacheKey])) 
            {
            return $appConfig['appVar_cache'][$cacheKey];
            }
        else 
            {
            return;
            }
        }

/**
 * @desc Проверяет наличие переменной в кеше
 * @return bool
 * @param component string Модуль к которому относится переменная
 * @param cacheKey string Ключь
 */
    public static function isCached($component, $cacheKey)
        {
        $cache_content = self::getCached($component, $cacheKey);
        if (isset($cache_content)) return true;
        return false;
        }

/**
 * @desc Удаляет переменную из кеша
 * @return bool
 * @param component string Модуль к которому относится переменная
 * @param cacheKey string Ключь
 */
    public static function deleteCached($component, $cacheKey)
        {
        global $appConfig;

        if (!self::isCached($component, $cacheKey)) 
            {    
            return true;
            }

        //Удлиняем $cacheKey
        $cacheKey = $component.'_'.$cacheKey;

        unset($appConfig['appVar_cache'][$cacheKey]);
        //В зависимости от типа уничтожаем информацию в кеше
        if ($appConfig['Var.caching'] == 'disk')
          {
          $cacheKey_crc = (string)abs(crc32($cacheKey));
          $file_way = './cache/vars/' . $component . '/'. $cacheKey_crc[0] . '/' . $cacheKey_crc[1] . '/' . $cacheKey;
          @unlink($file_way);
          }
        elseif ($appConfig['Var.caching'] == 'xcache')
          {
          xcache_unset('appVar_' . $cacheKey);
          }
        elseif ($appConfig['Var.caching'] == 'eaccelerator')
          {
          eaccelerator_rm('appVar_' . $cacheKey);
          }
        elseif ($appConfig['Var.caching'] == 'apc')
          {
          apc_delete('appVar_' . $cacheKey);
          }
        return true;
        }
        
    public static function deleteModuleAllCached($module)
        {
        appDirDelete('./cache/content/'.$module);
        appDirDelete('./cache/vars/'.$module);
        }
}
