﻿/**
 * Bulgarian translation
 * @author Stamo Petkov <stamo.petkov@gmail.com>
 * @version 2012-02-18
 */
if (elFinder && elFinder.prototype && typeof(elFinder.prototype.i18) == 'object') {
	elFinder.prototype.i18.bg = {
		translator : 'Stamo Petkov &lt;stamo.petkov@gmail.com&gt;',
		language   : 'Р‘СЉР»РіР°СЂСЃРєРё',
		direction  : 'ltr',
		messages   : {
			
			/********************************** errors **********************************/
			'error'                : 'Р“СЂРµС€РєР°',
			'errUnknown'           : 'РќРµРїРѕР·РЅР°С‚Р° РіСЂРµС€РєР°.',
			'errUnknownCmd'        : 'РќРµРїРѕР·РЅР°С‚Р° РєРѕРјР°РЅРґР°.',
			'errJqui'              : 'Р“СЂРµС€РЅР° РєРѕРЅС„РёРіСѓСЂР°С†РёСЏ РЅР° jQuery UI. РљРѕРјРїРѕРЅРµРЅС‚РёС‚Рµ selectable, draggable Рё droppable С‚СЂСЏР±РІР° РґР° СЃР° РІРєР»СЋС‡РµРЅРё.',
			'errNode'              : 'elFinder РёР·РёСЃРєРІР° РґР° Р±СЉРґРµ СЃСЉР·РґР°РґРµРЅ DOM РµР»РµРјРµРЅС‚.',
			'errURL'               : 'Р“СЂРµС€РєР° РІ РЅР°СЃС‚СЂРѕР№РєРёС‚Рµ РЅР° elFinder! РЅРµ Рµ Р·Р°РґР°РґРµРЅР° СЃС‚РѕР№РЅРѕСЃС‚ РЅР° URL.',
			'errAccess'            : 'Р”РѕСЃС‚СЉРї РѕС‚РєР°Р·Р°РЅ.',
			'errConnect'           : 'РќСЏРјР° РІСЂСЉР·РєР° СЃСЉСЃ СЃСЉСЂРІСЉСЂР°.',
			'errAbort'             : 'Р’СЂСЉР·РєР°С‚Р° Рµ РїСЂРµРєСЉСЃРЅР°С‚Р°.',
			'errTimeout'           : 'РџСЂРѕСЃСЂРѕС‡РµРЅР° РІСЂСЉР·РєР°.',
			'errNotFound'          : 'РЎСЉСЂРІСЉСЂСЉС‚ РЅРµ Рµ РЅР°РјРµСЂРµРЅ.', 
			'errResponse'          : 'Р“СЂРµС€РµРЅ РѕС‚РіРѕРІРѕСЂ РѕС‚ СЃСЉСЂРІСЉСЂР°.',
			'errConf'              : 'Р“СЂРµС€РЅРё РЅР°СЃС‚СЂРѕР№РєРё РЅР° СЃСЉСЂРІСЉСЂР°.', 
			'errJSON'              : 'РќРµ Рµ РёРЅСЃС‚Р°Р»РёСЂР°РЅ РјРѕРґСѓР» РЅР° PHP Р·Р° JSON.',
			'errNoVolumes'         : 'РќСЏРјР° РґСЏР»РѕРІРµ РґРѕСЃС‚СЉРїРЅРё Р·Р° С‡РµС‚РµРЅРµ.',
			'errCmdParams'         : 'Р“СЂРµС€РЅРё РїР°СЂР°РјРµС‚СЂРё РЅР° РєРѕРјР°РЅРґР°С‚Р° "$1".',
			'errDataNotJSON'       : 'Р”Р°РЅРЅРёС‚Рµ РЅРµ СЃР° JSON.',
			'errDataEmpty'         : 'Р›РёРїСЃРІР°С‚ РґР°РЅРЅРё.',
			'errCmdReq'            : 'Р—Р°РїРёС‚РІР°РЅРµС‚Рѕ РѕС‚ СЃСЉСЂРІСЉСЂР° РёР·РёСЃРєРІР° РёРјРµ РЅР° РєРѕРјР°РЅРґР°.',
			'errOpen'              : 'РќРµ РјРѕРіР° РґР° РѕС‚РІРѕСЂСЏ "$1".',
			'errNotFolder'         : 'РћР±РµРєС‚СЉС‚ РЅРµ Рµ РїР°РїРєР°.',
			'errNotFile'           : 'РћР±РµРєС‚СЉС‚ РЅРµ Рµ С„Р°РёР».',
			'errRead'              : 'РќРµ РјРѕРіР° РґР° РїСЂРѕС‡РµС‚Р° "$1".',
			'errWrite'             : 'РќРµ РјРѕРіР° РґР° РїРёС€Р° РІ "$1".',
			'errPerm'              : 'Р Р°Р·СЂРµС€РµРЅРёРµ РѕС‚РєР°Р·Р°РЅРѕ.',
			'errLocked'            : '"$1" Рµ Р·Р°РєР»СЋС‡РµРЅ Рё РЅРµ РјРѕР¶Рµ РґР° Р±СЉРґРµ РїСЂРµРёРјРµРЅСѓРІР°РЅ, РјРµСЃС‚РµРЅ РёР»Рё РїСЂРµРјР°С…РІР°РЅ.',
			'errExists'            : 'Р’РµС‡Рµ СЃСЉС‰РµСЃС‚РІСѓРІР° С„Р°Р№Р» СЃ РёРјРµ "$1"',
			'errInvName'           : 'Р“СЂРµС€РЅРѕ РёРјРµ РЅР° С„Р°РёР».',
			'errFolderNotFound'    : 'РџР°РїРєР°С‚Р° РЅРµ Рµ РѕС‚РєСЂРёС‚Р°.',
			'errFileNotFound'      : 'Р¤Р°РёР»СЉС‚ РЅРµ Рµ РѕС‚РєСЂРёС‚.',
			'errTrgFolderNotFound' : 'Р¦РµР»РµРІР°С‚Р° РїР°РїРєР° "$1" РЅРµ Рµ РЅР°РјРµСЂРµРЅР°.',
			'errPopup'             : 'Р‘СЂР°СѓР·СЉСЂР° Р±Р»РѕРєРёСЂР° РѕС‚РІР°СЂСЏРЅРµС‚Рѕ РЅР° РїСЂРѕР·РѕСЂРµС†. Р—Р° РґР° РѕС‚РІРѕСЂРёС‚Рµ С„Р°Р№Р»Р°, СЂР°Р·СЂРµС€РµС‚Рµ РѕС‚РІР°СЂСЏРЅРµС‚Рѕ РІ РЅР°СЃС‚СЂРѕР№РєРёС‚Рµ РЅР° Р±СЂР°СѓР·СЉСЂР°.',
			'errMkdir'             : 'РќРµ РјРѕРіР° РґР° СЃСЉР·РґР°Рј РїР°РїРєР°"$1".',
			'errMkfile'            : 'РќРµ РјРѕРіР° РґР° СЃСЉР·РґР°Рј С„Р°Р№Р» "$1".',
			'errRename'            : 'РќРµ РјРѕРіР° РґР° РїСЂРµРёРјРµРЅСѓРІР°Рј "$1".',
			'errCopyFrom'          : 'РљРѕРїРёСЂР°РЅРµС‚Рѕ РЅР° С„Р°Р№Р»РѕРІРµ РѕС‚ С‚РѕРј "$1" РЅРµ Рµ СЂР°Р·СЂРµС€РµРЅРѕ.',
			'errCopyTo'            : 'РљРѕРїРёСЂР°РЅРµС‚Рѕ РЅР° С„Р°Р№Р»РѕРІРµ РІ С‚РѕРј "$1" РЅРµ Рµ СЂР°Р·СЂРµС€РµРЅРѕ.',
			'errUploadCommon'      : 'Р“СЂРµС€РєР° РїСЂРё РєР°С‡РІР°РЅРµ.',
			'errUpload'            : 'РќРµ РјРѕРіР° РґР° РєР°С‡Р° "$1".',
			'errUploadNoFiles'     : 'РќРµ СЃР° РЅР°РјРµСЂРµРЅРё С„Р°Р№Р»РѕРІРµ Р·Р° РєР°С‡РІР°РЅРµ.',
			'errMaxSize'           : 'Р”Р°РЅРЅРёС‚Рµ РїСЂРµРІРёС€Р°РІР°С‚ РјР°РєСЃРёРјР°Р»РЅРѕ РґРѕРїРѕСЃС‚СѓРјРёСЏ СЂР°Р·РјРµСЂ.',
			'errFileMaxSize'       : 'Р¤Р°Р№Р»Р° РїСЂРµРІРёС€Р°РІР° РјР°РєСЃРёРјР°Р»РЅРѕ РґРѕРїСѓСЃС‚РёРјРёСЏ СЂР°Р·РјРµСЂ.',
			'errUploadMime'        : 'РќРµ Рµ РїРѕР·РІРѕР»РµРЅ С‚РёРї РЅР° С„Р°Р№Р»Р°.',
			'errUploadTransfer'    : '"$1" РіСЂРµС€РєР° РїСЂРё РїСЂРµРґР°РІР°РЅРµ.', 
			'errSave'              : 'РќРµ РјРѕРіР° РґР° Р·Р°РїРёС€Р° "$1".',
			'errCopy'              : 'РќРµ РјРѕРіР° РґР° РєРѕРїРёСЂР°Рј "$1".',
			'errMove'              : 'РќРµ РјРѕРіР° РґР° РїСЂРµРјРµСЃС‚СЏ "$1".',
			'errCopyInItself'      : 'РќРµ РјРѕРіР° РґР° РєРѕРїРёСЂР°Рј "$1" РІСЉСЂС…Сѓ СЃР°РјРёСЏ РЅРµРіРѕ.',
			'errRm'                : 'РќРµ РјРѕРіР° РґР° РїСЂРµРјР°С…РЅР° "$1".',
			'errExtract'           : 'РќРµ РјРѕРіР° РґР° РёР·РІР»РµС‡Р° С„Р°Р№Р»РѕРІРµС‚Рµ РѕС‚ "$1".',
			'errArchive'           : 'РќРµ РјРѕРіР° РґР° СЃСЉР·РґР°Рј Р°СЂС…РёРІ.',
			'errArcType'           : 'РќРµРїРѕРґРґСЉСЂР¶Р°РЅ С‚РёРї РЅР° Р°СЂС…РёРІР°.',
			'errNoArchive'         : 'Р¤Р°Р№Р»СЉС‚ РЅРµ Рµ Р°СЂС…РёРІ РёР»Рё Рµ РѕС‚ РЅРµРїРѕРґРґСЉСЂР¶Р°РЅ С‚РёРї.',
			'errCmdNoSupport'      : 'РЎСЉСЂРІСЉСЂР° РЅРµ РїРѕРґРґСЉСЂР¶Р° С‚Р°Р·Рё РєРѕРјР°РЅРґР°.', 
			'errReplByChild'       : 'РџР°РїРєР°С‚Р° вЂњ$1вЂќ РЅРµ РјРѕР¶Рµ РґР° Р±СЉРґРµ Р·Р°РјРµРЅРµРЅР° РѕС‚ СЃСЉРґСЉСЂР¶Р°С‰ СЃРµ РІ РЅРµСЏ РµР»РµРјРµРЅС‚.',
			'errArcSymlinks'       : 'РћС‚ СЃСЉРѕР±СЂР°Р¶РµРЅРёСЏ Р·Р° СЃРёРіСѓСЂРЅРѕСЃС‚ РЅСЏРјР° РґР° Р±СЉРґР°С‚ СЂР°Р·РѕРїР°РєРѕРІР°РЅРё Р°СЂС…РёРІРё СЃСЉРґСЉСЂР¶Р°С‰Рё symlinks.',
			'errArcMaxSize'        : 'РђСЂС…РёРІРЅРёС‚Рµ С„Р°Р№Р»РѕРІРµ РїСЂРµРІРёС€Р°РІР°С‚ РјР°РєСЃРёРјР°Р»РЅРѕ РґРѕРїСѓСЃС‚РёРјРёСЏ СЂР°Р·РјРµСЂ.',
			'errResize'            : 'РќРµ РјРѕРіР° РґР° РїСЂРµРѕСЂР°Р·РјРµСЂСЏ "$1".',
			'errUsupportType'      : 'РќРµРїРѕРґРґСЉСЂР¶Р°РЅ С‚РёРї С„Р°Р№Р».',
			
			/******************************* commands names ********************************/
			'cmdarchive'   : 'РЎСЉР·РґР°Р№ Р°СЂС…РёРІ',
			'cmdback'      : 'РќР°Р·Р°Рґ',
			'cmdcopy'      : 'РљРѕРїРёСЂР°Р№',
			'cmdcut'       : 'РР·СЂРµР¶Рё',
			'cmddownload'  : 'РЎРІР°Р»Рё',
			'cmdduplicate' : 'Р”СѓР±Р»РёСЂР°Р№',
			'cmdedit'      : 'Р РµРґР°РєС‚РёСЂР°Р№ С„Р°Р№Р»',
			'cmdextract'   : 'РР·РІР»РµС‡Рё С„Р°Р№Р»РѕРІРµС‚Рµ РѕС‚ Р°СЂС…РёРІР°',
			'cmdforward'   : 'РќР°РїСЂРµРґ',
			'cmdgetfile'   : 'РР·Р±РµСЂРё С„Р°Р№Р»РѕРІРµ',
			'cmdhelp'      : 'Р—Р° С‚Р°Р·Рё РїСЂРѕРіСЂР°РјР°',
			'cmdhome'      : 'РќР°С‡Р°Р»Рѕ',
			'cmdinfo'      : 'РРЅС„РѕСЂРјР°С†РёСЏ',
			'cmdmkdir'     : 'РќРѕРІР° РїР°РїРєР°',
			'cmdmkfile'    : 'РќРѕРІ С‚РµРєСЃС‚РѕРІРё С„Р°Р№Р»',
			'cmdopen'      : 'РћС‚РІРѕСЂРё',
			'cmdpaste'     : 'Р’РјСЉРєРЅРё',
			'cmdquicklook' : 'РџСЂРµРіР»РµРґ',
			'cmdreload'    : 'РџСЂРµР·Р°СЂРµРґРё',
			'cmdrename'    : 'РџСЂРµРёРјРµРЅСѓРІР°Р№',
			'cmdrm'        : 'РР·С‚СЂРёР№',
			'cmdsearch'    : 'РќР°РјРµСЂРё С„Р°Р№Р»РѕРІРµ',
			'cmdup'        : 'Р•РґРЅР° РґРёСЂРµРєС‚РѕСЂРёСЏ РЅР°РіРѕСЂРµ',
			'cmdupload'    : 'РљР°С‡Рё С„Р°Р№Р»РѕРІРµС‚Рµ',
			'cmdview'      : 'Р’РёР¶',
			'cmdresize'    : 'Р Р°Р·РјРµСЂ РЅР° РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'cmdsort'      : 'РџРѕРґСЂРµРґРё',
			
			/*********************************** buttons ***********************************/ 
			'btnClose'  : 'Р—Р°С‚РІРѕСЂРё',
			'btnSave'   : 'Р—Р°РїРёС€Рё',
			'btnRm'     : 'РџСЂРµРјР°С…РЅРё',
			'btnApply'  : 'РџСЂРёР»РѕР¶Рё',
			'btnCancel' : 'РћС‚РєР°Р·',
			'btnNo'     : 'РќРµ',
			'btnYes'    : 'Р”Р°',
			
			/******************************** notifications ********************************/
			'ntfopen'     : 'РћС‚РІР°СЂСЏРЅРµ РЅР° РїР°РїРєР°',
			'ntffile'     : 'РћС‚РІР°СЂСЏРЅРµ РЅР° С„Р°Р№Р»',
			'ntfreload'   : 'РџСЂРµР·Р°СЂРµР¶РґР°РЅРµ СЃСЉРґСЉСЂР¶Р°РЅРёРµС‚Рѕ РЅР° РїР°РїРєР°',
			'ntfmkdir'    : 'РЎСЉР·РґР°РІР°Рј РґРёСЂРµРєС‚РѕСЂРёСЏ',
			'ntfmkfile'   : 'РЎСЉР·РґР°РІР°Рј С„Р°Р№Р»',
			'ntfrm'       : 'РР·С‚СЂРёРІР°РЅРµ РЅР° С„Р°Р№Р»РѕРІРµ',
			'ntfcopy'     : 'РљРѕРїРёСЂР°РЅРµ РЅР° С„Р°Р№Р»РѕРІРµ',
			'ntfmove'     : 'РџСЂРµРјРµСЃС‚РІР°РЅРµ РЅР° С„Р°Р№Р»РѕРІРµ',
			'ntfprepare'  : 'РџРѕРґРіРѕС‚РѕРІРєР° Р·Р° РєРѕРїРёСЂР°РЅРµ РЅР° С„Р°Р№Р»РѕРІРµ',
			'ntfrename'   : 'РџСЂРµРёРјРµРЅСѓРІР°РЅРµ РЅР° С„Р°Р№Р»РѕРІРµ',
			'ntfupload'   : 'РљР°С‡РІР°Рј С„Р°Р№Р»РѕРІРµ',
			'ntfdownload' : 'РЎРІР°Р»СЏРј С„Р°Р№Р»РѕРІРµ',
			'ntfsave'     : 'Р—Р°РїРёСЃ РЅР° С„Р°Р№Р»РѕРІРµ',
			'ntfarchive'  : 'РЎСЉР·РґР°РІР°Рј Р°СЂС…РёРІ',
			'ntfextract'  : 'РР·РІР»РёС‡Р°Рј С„Р°Р№Р»РѕРІРµС‚Рµ РѕС‚ Р°СЂС…РёРІ',
			'ntfsearch'   : 'РўСЉСЂСЃСЏ С„Р°Р№Р»РѕРІРµ',
			'ntfsmth'     : 'Р—Р°РµС‚ СЃСЉРј >_<',
			'ntfloadimg'  : 'Р—Р°СЂРµР¶РґР°Рј РёР·РѕР±СЂР°Р¶РµРЅРёСЏ',
			
			/************************************ dates **********************************/
			'dateUnknown' : 'РЅРµРёР·РІРµСЃС‚РЅР°',
			'Today'       : 'Р”РЅРµСЃ',
			'Yesterday'   : 'Р’С‡РµСЂР°',
			'Jan'         : 'РЇРЅСѓ',
			'Feb'         : 'Р¤РµРІ',
			'Mar'         : 'РњР°СЂ',
			'Apr'         : 'РђРїСЂ',
			'May'         : 'РњР°Р№',
			'Jun'         : 'Р®РЅРё',
			'Jul'         : 'Р®Р»Рё',
			'Aug'         : 'РђРІРі',
			'Sep'         : 'РЎРµРї',
			'Oct'         : 'РћРєС‚',
			'Nov'         : 'РќРѕРµ',
			'Dec'         : 'Р”РµРє',
			
			/******************************** sort variants ********************************/
			'sortnameDirsFirst' : 'РїРѕ РёРјРµ (РїСЉСЂРІРѕ РїР°РїРєРёС‚Рµ)', 
			'sortkindDirsFirst' : 'РїРѕ РІРёРґ (РїСЉСЂРІРѕ РїР°РїРєРёС‚Рµ)', 
			'sortsizeDirsFirst' : 'РїРѕ СЂР°Р·РјРµСЂ (РїСЉСЂРІРѕ РїР°РїРєРёС‚Рµ)', 
			'sortdateDirsFirst' : 'РїРѕ РґР°С‚Р° (РїСЉСЂРІРѕ РїР°РїРєРёС‚Рµ)', 
			'sortname'          : 'РїРѕ РёРјРµ', 
			'sortkind'          : 'РїРѕ РІРёРґ', 
			'sortsize'          : 'РїРѕ СЂР°Р·РјРµСЂ',
			'sortdate'          : 'РїРѕ РґР°С‚Р°',
			
			/********************************** messages **********************************/
			'confirmReq'      : 'РР·РёСЃРєРІР° СЃРµ РїРѕРґС‚РІСЉСЂР¶РґРµРЅРёРµ',
			'confirmRm'       : 'РЎРёРіСѓСЂРЅРё Р»Рё СЃС‚Рµ, С‡Рµ Р¶РµР»Р°РµС‚Рµ РґР° РїСЂРµРјР°С…РЅРµС‚Рµ С„Р°Р№Р»РѕРІРµС‚Рµ?<br/>РўРѕРІР° РґРµР№СЃС‚РІРёРµ Рµ РЅРµРѕР±СЂР°С‚РёРјРѕ!',
			'confirmRepl'     : 'Р”Р° Р·Р°РјРµРЅСЏ Р»Рё СЃС‚Р°СЂРёСЏ С„Р°РёР» СЃ РЅРѕРІРёСЏ?',
			'apllyAll'        : 'РџСЂРёР»РѕР¶Рё Р·Р° РІСЃРёС‡РєРё',
			'name'            : 'РРјРµ',
			'size'            : 'Р Р°Р·РјРµСЂ',
			'perms'           : 'РџСЂРёРІРёР»РµРіРёРё',
			'modify'          : 'РџСЂРѕРјРµРЅРµРЅ',
			'kind'            : 'Р’РёРґ',
			'read'            : 'С‡РµС‚РµРЅРµ',
			'write'           : 'Р·Р°РїРёСЃ',
			'noaccess'        : 'Р±РµР· РґРѕСЃС‚СЉРї',
			'and'             : 'Рё',
			'unknown'         : 'РЅРµРїРѕР·РЅР°С‚',
			'selectall'       : 'РР·Р±РµСЂРё РІСЃРёС‡РєРё С„Р°Р№Р»РѕРІРµ',
			'selectfiles'     : 'РР·Р±РµСЂРё С„Р°РёР»(РѕРІРµ)',
			'selectffile'     : 'РР·Р±РµСЂРё РїСЉСЂРІРёСЏС‚ С„Р°Р№Р»',
			'selectlfile'     : 'РР·Р±РµСЂРё РїРѕСЃР»РµРґРЅРёСЏС‚ С„Р°Р№Р»',
			'viewlist'        : 'РР·РіР»РµРґ СЃРїРёСЃСЉРє',
			'viewicons'       : 'РР·РіР»РµРґ РёРєРѕРЅРё',
			'places'          : 'РњРµСЃС‚Р°',
			'calc'            : 'РР·С‡РёСЃР»Рё', 
			'path'            : 'РџСЉС‚',
			'aliasfor'        : 'Р’СЂСЉР·РєР° РєСЉРј',
			'locked'          : 'Р—Р°РєР»СЋС‡РµРЅ',
			'dim'             : 'Р Р°Р·РјРµСЂРё',
			'files'           : 'Р¤Р°Р№Р»РѕРІРµ',
			'folders'         : 'РџР°РїРєРё',
			'items'           : 'Р•Р»РµРјРµРЅС‚Рё',
			'yes'             : 'РґР°',
			'no'              : 'РЅРµ',
			'link'            : 'Р’СЂСЉР·РєР°',
			'searcresult'     : 'Р РµР·СѓР»С‚Р°С‚Рё РѕС‚ С‚СЉСЂСЃРµРЅРµС‚Рѕ',  
			'selected'        : 'РР·Р±СЂР°РЅРё РµР»РµРјРµРЅС‚Рё',
			'about'           : 'Р—Р°',
			'shortcuts'       : 'РїСЂРµРєРё РїСЉС‚РёС‰Р°',
			'help'            : 'РџРѕРјРѕС‰',
			'webfm'           : 'Р¤Р°Р№Р»РѕРІ РјРµРЅР°РґР¶РµСЂ Р·Р° web',
			'ver'             : 'Р’РµСЂСЃРёСЏ',
			'protocolver'        : 'РІРµСЂСЃРёСЏ РЅР° РїСЂРѕС‚РѕРєРѕР»Р°',
			'homepage'        : 'РќР°С‡Р°Р»Рѕ',
			'docs'            : 'Р”РѕРєСѓРјРµРЅС‚Р°С†РёСЏ',
			'github'          : 'Р Р°Р·РєР»РѕРЅРµРЅРёРµ РІ Github',
			'twitter'         : 'РџРѕСЃР»РµРґРІР°Р№С‚Рµ РЅРё РІ Twitter',
			'facebook'        : 'РџСЂРёСЃСЉРµРґРёРЅРµС‚Рµ СЃРµ РєСЉРј РЅР°СЃ РІСЉРІ Facebook',
			'team'            : 'Р•РєРёРї',
			'chiefdev'        : 'Р“Р»Р°РІРµРЅ СЂР°Р·СЂР°Р±РѕС‚С‡РёРє',
			'developer'       : 'СЂР°Р·СЂР°Р±РѕС‚С‡РёРє',
			'contributor'     : 'СЃСЉС‚СЂСѓРґРЅРёРє',
			'maintainer'      : 'РїРѕРґРґСЂСЉР¶РєР°',
			'translator'      : 'РїСЂРµРІРѕРґР°С‡',
			'icons'           : 'РРєРѕРЅРё',
			'dontforget'      : 'Рё РЅРµ Р·Р°Р±СЂР°РІСЏР№С‚Рµ РґР° СЃРё РІР·РµРјРµС‚Рµ РєСЉСЂРїР°С‚Р°',
			'shortcutsof'     : 'РџСЂРµРєРёС‚Рµ РїСЉС‚РёС‰Р° СЃР° РёР·РєР»СЋС‡РµРЅРё',
			'dropFiles'       : 'РџСѓСЃРЅРµС‚Рµ С„Р°Р№Р»РѕРІРµС‚Рµ С‚СѓРє',
			'or'              : 'РёР»Рё',
			'selectForUpload' : 'РР·Р±РµСЂРµС‚Рµ С„Р°Р№Р»РѕРІРµ Р·Р° РєР°С‡РІР°РЅРµ',
			'moveFiles'       : 'РџСЂРµРјРµСЃС‚Рё С„Р°Р№Р»РѕРІРµ',
			'copyFiles'       : 'РљРѕРїРёСЂР°Р№ С„Р°Р№Р»РѕРІРµ',
			'rmFromPlaces'    : 'РџСЂРµРјР°С…РЅРё РѕС‚ РњРµСЃС‚Р°',
			'untitled folder' : 'РќРµРѕР·Р°РіР»Р°РІРµРЅР° РїР°РїРєР°',
			'untitled file.txt' : 'РЅРµРѕР·Р°РіР»Р°РІРµРЅ_С„Р°Р№Р».txt',
			'aspectRatio'     : 'РћС‚РЅРѕС€РµРЅРёРµ',
			'scale'           : 'РњР°С‰Р°Р±',
			'width'           : 'РЁРёСЂРёРЅР°',
			'height'          : 'Р’РёСЃРѕС‡РёРЅР°',
			'mode'            : 'Р РµР¶РёРј',
			'resize'          : 'РџСЂРµРѕСЂР°Р·РјРµСЂРё',
			'crop'            : 'РћС‚СЂРµР¶Рё',

			
			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'РќРµРїРѕР·РЅР°С‚',
			'kindFolder'      : 'РџР°РїРєР°',
			'kindAlias'       : 'Р’СЂСЉР·РєР°',
			'kindAliasBroken' : 'РЎС‡СѓРїРµРЅР° РІСЂСЉР·РєР°',
			// applications
			'kindApp'         : 'РџСЂРёР»РѕР¶РµРЅРёРµ',
			'kindPostscript'  : 'Postscript РґРѕРєСѓРјРµРЅС‚',
			'kindMsOffice'    : 'Microsoft Office РґРѕРєСѓРјРµРЅС‚',
			'kindMsWord'      : 'Microsoft Word РґРѕРєСѓРјРµРЅС‚',
			'kindMsExcel'     : 'Microsoft Excel РґРѕРєСѓРјРµРЅС‚',
			'kindMsPP'        : 'Microsoft Powerpoint РїСЂРµР·РµРЅС‚Р°С†РёСЏ',
			'kindOO'          : 'Open Office РґРѕРєСѓРјРµРЅС‚',
			'kindAppFlash'    : 'Flash РїСЂРёР»РѕР¶РµРЅРёРµ',
			'kindPDF'         : 'PDF РґРѕРєСѓРјРµРЅС‚',
			'kindTorrent'     : 'Bittorrent С„Р°Р№Р»',
			'kind7z'          : '7z Р°СЂС…РёРІ',
			'kindTAR'         : 'TAR Р°СЂС…РёРІ',
			'kindGZIP'        : 'GZIP Р°СЂС…РёРІ',
			'kindBZIP'        : 'BZIP Р°СЂС…РёРІ',
			'kindZIP'         : 'ZIP Р°СЂС…РёРІ',
			'kindRAR'         : 'RAR Р°СЂС…РёРІ',
			'kindJAR'         : 'Java JAR С„Р°Р№Р»',
			'kindTTF'         : 'True Type С€СЂРёС„С‚',
			'kindOTF'         : 'Open Type С€СЂРёС„С‚',
			'kindRPM'         : 'RPM РїР°РєРµС‚',
			// texts
			'kindText'        : 'РўРµРєСЃС‚РѕРІ РґРѕРєСѓРјРµРЅС‚',
			'kindTextPlain'   : 'Р§РёСЃС‚ С‚РµРєСЃС‚',
			'kindPHP'         : 'PHP РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindCSS'         : 'CSS С‚Р°Р±Р»РёС†Р° СЃСЉСЃ СЃС‚РёР»РѕРІРµ',
			'kindHTML'        : 'HTML РґРѕРєСѓРјРµРЅС‚',
			'kindJS'          : 'Javascript РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindRTF'         : 'RTF С‚РµРєСЃС‚РѕРІРё С„Р°Р№Р»',
			'kindC'           : 'C РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindCHeader'     : 'C header РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindCPP'         : 'C++ РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindCPPHeader'   : 'C++ header РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindShell'       : 'Unix shell script',
			'kindPython'      : 'Python РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindJava'        : 'Java РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindRuby'        : 'Ruby РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindPerl'        : 'Perl РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindSQL'         : 'SQL РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindXML'         : 'XML РґРѕРєСѓРјРµРЅС‚',
			'kindAWK'         : 'AWK РёР·С…РѕРґРµРЅ РєРѕРґ',
			'kindCSV'         : 'CSV СЃС‚РѕР№РЅРѕСЃС‚Рё СЂР°Р·РґРµР»РµРЅРё СЃСЉСЃ Р·Р°РїРµС‚Р°СЏ',
			'kindDOCBOOK'     : 'Docbook XML РґРѕРєСѓРјРµРЅС‚',
			// images
			'kindImage'       : 'РР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindBMP'         : 'BMP РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindJPEG'        : 'JPEG РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindGIF'         : 'GIF РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindPNG'         : 'PNG РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindTIFF'        : 'TIFF РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindTGA'         : 'TGA РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindPSD'         : 'Adobe Photoshop РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindXBITMAP'     : 'X bitmap РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			'kindPXM'         : 'Pixelmator РёР·РѕР±СЂР°Р¶РµРЅРёРµ',
			// media
			'kindAudio'       : 'РђСѓРґРёРѕ РјРµРґРёСЏ',
			'kindAudioMPEG'   : 'MPEG Р·РІСѓРє',
			'kindAudioMPEG4'  : 'MPEG-4 Р·РІСѓРє',
			'kindAudioMIDI'   : 'MIDI Р·РІСѓРє',
			'kindAudioOGG'    : 'Ogg Vorbis Р·РІСѓРє',
			'kindAudioWAV'    : 'WAV Р·РІСѓРє',
			'AudioPlaylist'   : 'MP3 СЃРїРёСЃСЉРє Р·Р° РёР·РїСЉР»РЅРµРЅРёРµ',
			'kindVideo'       : 'Р’РёРґРµРѕ РјРµРґРёСЏ',
			'kindVideoDV'     : 'DV С„РёР»Рј',
			'kindVideoMPEG'   : 'MPEG С„РёР»Рј',
			'kindVideoMPEG4'  : 'MPEG-4 С„РёР»Рј',
			'kindVideoAVI'    : 'AVI С„РёР»Рј',
			'kindVideoMOV'    : 'Quick Time С„РёР»Рј',
			'kindVideoWM'     : 'Windows Media С„РёР»Рј',
			'kindVideoFlash'  : 'Flash С„РёР»Рј',
			'kindVideoMKV'    : 'Matroska С„РёР»Рј',
			'kindVideoOGG'    : 'Ogg С„РёР»Рј'
		}
	}
}
