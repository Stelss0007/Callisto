﻿/**
 * Vietnamese translation
 * @author Chung Thб»§y f <chungthuyf@gmail.com>
 * @version 16-01-2013
 */
if (elFinder && elFinder.prototype && typeof(elFinder.prototype.i18) == 'object') {
  elFinder.prototype.i18.vi = {
    translator : 'Chung Thб»§y f &lt;chungthuyf@gmail.com&gt;',
    language : 'NgГґn ngб»Ї Viб»‡t Nam',
    direction : 'ltr',
    dateFormat : 'd.m.Y H:i',
    fancyDateFormat : '$1 H:i',
    messages : {

        /********************************** errors **********************************/
        'error'                : 'Lб»—i',
        'errUnknown'           : 'Lб»—i khГґng xГЎc Д‘б»‹nh Д‘Ж°б»Јc.',
        'errUnknownCmd'        : 'Lб»—i khГґng rГµ lб»‡nh.',
        'errJqui'              : 'Invalid jQuery UI configuration. Selectable, draggable and droppable components must be included.',
        'errNode'              : 'elFinder requires DOM Element to be created.',
        'errURL'               : 'CбєҐu elFinder khГґng hб»Јp lб»‡! URL khГґng Д‘Ж°б»Јc thiбєїt lбє­p tГ№y chб»Ќn.',
        'errAccess'            : 'Truy cбє­p bб»‹ tб»« chб»‘i.',
        'errConnect'           : 'Unable to connect to backend.',
        'errAbort'             : 'Kбєїt nб»‘i bб»‹ hб»§y bб»Џ.',
        'errTimeout'           : 'Connection timeout.',
        'errNotFound'          : 'Backend not found.',
        'errResponse'          : 'Invalid backend response.',
        'errConf'              : 'Invalid backend configuration.',
        'errJSON'              : 'PHP JSON module not installed.',
        'errNoVolumes'         : 'Readable volumes not available.',
        'errCmdParams'         : 'Invalid parameters for command "$1".',
        'errDataNotJSON'       : 'Data is not JSON.',
        'errDataEmpty'         : 'Data is empty.',
        'errCmdReq'            : 'Backend request requires command name.',
        'errOpen'              : 'Unable to open "$1".',
        'errNotFolder'         : 'Object is not a folder.',
        'errNotFile'           : 'Object is not a file.',
        'errRead'              : 'Unable to read "$1".',
        'errWrite'             : 'Unable to write into "$1".',
        'errPerm'              : 'Permission denied.',
        'errLocked'            : '"$1" is locked and can not be renamed, moved or removed.',
        'errExists'            : 'File named "$1" already exists.',
        'errInvName'           : 'Invalid file name.',
        'errFolderNotFound'    : 'Folder not found.',
        'errFileNotFound'      : 'File not found.',
        'errTrgFolderNotFound' : 'Target folder "$1" not found.',
        'errPopup'             : 'Browser prevented opening popup window. To open file enable it in browser options.',
        'errMkdir'             : 'Unable to create folder "$1".',
        'errMkfile'            : 'Unable to create file "$1".',
        'errRename'            : 'Unable to rename "$1".',
        'errCopyFrom'          : 'Copying files from volume "$1" not allowed.',
        'errCopyTo'            : 'Copying files to volume "$1" not allowed.',
        'errUploadCommon'      : 'Upload error.',
        'errUpload'            : 'Unable to upload "$1".',
        'errUploadNoFiles'     : 'No files found for upload.',
        'errMaxSize'           : 'Data exceeds the maximum allowed size.',
        'errFileMaxSize'       : 'File exceeds maximum allowed size.',
        'errUploadMime'        : 'File type not allowed.',
        'errUploadTransfer'    : '"$1" transfer error.', 
        'errSave'              : 'Unable to save "$1".',
        'errCopy'              : 'Unable to copy "$1".',
        'errMove'              : 'Unable to move "$1".',
        'errCopyInItself'      : 'Unable to copy "$1" into itself.',
        'errRm'                : 'Unable to remove "$1".',
        'errExtract'           : 'Unable to extract files from "$1".',
        'errArchive'           : 'Unable to create archive.',
        'errArcType'           : 'Unsupported archive type.',
        'errNoArchive'         : 'File is not archive or has unsupported archive type.',
        'errCmdNoSupport'      : 'Backend does not support this command.',
        'errReplByChild'       : 'The folder вЂњ$1вЂќ canвЂ™t be replaced by an item it contains.',
        'errArcSymlinks'       : 'For security reason denied to unpack archives contains symlinks.',
        'errArcMaxSize'        : 'Archive files exceeds maximum allowed size.',
        'errResize'            : 'Unable to resize "$1".',
        'errUsupportType'      : 'Unsupported file type.',

        /******************************* commands names ********************************/
        'cmdarchive'   : 'TбєЎo tбє­p tin nГ©n',
        'cmdback'      : 'Trб»џ lбєЎi',
        'cmdcopy'      : 'Sao chГ©p',
        'cmdcut'       : 'CбєЇt',
        'cmddownload'  : 'TбєЈi vб»Ѓ',
        'cmdduplicate' : 'BбєЈn sao',
        'cmdedit'      : 'Sб»­a tбє­p tin',
        'cmdextract'   : 'GiбєЈi nГ©n tбє­p tin',
        'cmdforward'   : 'TrЖ°б»›c',
        'cmdgetfile'   : 'Chб»Ќn tбє­p tin',
        'cmdhelp'      : 'Giб»›i thiб»‡u phбє§n mб»Ѓm',
        'cmdhome'      : 'Home',
        'cmdinfo'      : 'ThГґng tin',
        'cmdmkdir'     : 'ThЖ° mб»Ґc',
        'cmdmkfile'    : 'TбєЎo tбє­p tin Text',
        'cmdopen'      : 'Mб»џ',
        'cmdpaste'     : 'Paste',
        'cmdquicklook' : 'Xem trЖ°б»›c',
        'cmdreload'    : 'NбєЎp lбєЎi',
        'cmdrename'    : 'Дђб»•i tГЄn',
        'cmdrm'        : 'XГіa',
        'cmdsearch'    : 'TГ¬m tбє­p tin',
        'cmdup'        : 'Go to parent directory',
        'cmdupload'    : 'TбєЈi tбє­p tin lГЄn',
        'cmdview'      : 'Xem',
        'cmdresize'    : 'Resize image',
        'cmdsort'      : 'SбєЇp xбєїp',

        /*********************************** buttons ***********************************/ 
        'btnClose'  : 'ДђГіng',
        'btnSave'   : 'LЖ°u',
        'btnRm'     : 'Gб»Ў bб»Џ',
        'btnApply'  : 'ГЃp dб»Ґng',
        'btnCancel' : 'Hб»§y bб»Џ',
        'btnNo'     : 'KhГґng',
        'btnYes'    : 'Дђб»“ng ГЅ',

        /******************************** notifications ********************************/
        'ntfopen'     : 'Mб»џ thЖ° mб»Ґc',
        'ntffile'     : 'Mб»џ tбє­p tin',
        'ntfreload'   : 'NбєЎp lбєЎi nб»™i dung thЖ° mб»Ґc',
        'ntfmkdir'    : 'TбєЎo thЖ° mб»Ґc',
        'ntfmkfile'   : 'TбєЎo tбє­p tin',
        'ntfrm'       : 'XГіa tбє­p tin',
        'ntfcopy'     : 'Sao chГ©p tбє­p tin',
        'ntfmove'     : 'Di chuyб»ѓn tбє­p tin',
        'ntfprepare'  : 'Chuбє©n bб»‹ Д‘б»ѓ sao chГ©p cГЎc tбє­p tin',
        'ntfrename'   : 'Дђб»•i tГЄn tбє­p tin',
        'ntfupload'   : 'TбєЈi tбє­p tin lГЄn',
        'ntfdownload' : 'TбєЈi tбє­p tin',
        'ntfsave'     : 'LЖ°u tбє­p tin',
        'ntfarchive'  : 'TбєЎo tбє­p tin nГ©n',
        'ntfextract'  : 'GiбєЈi nГ©n tбє­p tin',
        'ntfsearch'   : 'TГ¬m kiбєїm tбє­p tin',
        'ntfsmth'     : 'Doing something >_<',
        'ntfloadimg'  : 'Дђang tбєЈi hГ¬nh бєЈnh',

        /************************************ dates **********************************/
        'dateUnknown' : 'ChЖ°a biбєїt',
        'Today'       : 'HГґm nay',
        'Yesterday'   : 'Yesterday',
        'Jan'         : 'Jan',
        'Feb'         : 'Feb',
        'Mar'         : 'Mar',
        'Apr'         : 'Apr',
        'May'         : 'May',
        'Jun'         : 'Jun',
        'Jul'         : 'Jul',
        'Aug'         : 'Aug',
        'Sep'         : 'Sep',
        'Oct'         : 'Oct',
        'Nov'         : 'Nov',
        'Dec'         : 'Dec',
        'January'     : 'January',
        'February'    : 'February',
        'March'       : 'March',
        'April'       : 'April',
        'May'         : 'May',
        'June'        : 'June',
        'July'        : 'July',
        'August'      : 'August',
        'September'   : 'September',
        'October'     : 'October',
        'November'    : 'November',
        'December'    : 'December',
        'Sunday'      : 'Sunday', 
        'Monday'      : 'Monday', 
        'Tuesday'     : 'Tuesday', 
        'Wednesday'   : 'Wednesday', 
        'Thursday'    : 'Thursday', 
        'Friday'      : 'Friday', 
        'Saturday'    : 'Saturday',
        'Sun'         : 'Sun', 
        'Mon'         : 'Mon', 
        'Tue'         : 'Tue', 
        'Wed'         : 'Wed', 
        'Thu'         : 'Thu', 
        'Fri'         : 'Fri', 
        'Sat'         : 'Sat',
        /******************************** sort variants ********************************/
        'sortnameDirsFirst' : 'by name (folders first)', 
        'sortkindDirsFirst' : 'by kind (folders first)', 
        'sortsizeDirsFirst' : 'by size (folders first)', 
        'sortdateDirsFirst' : 'by date (folders first)', 
        'sortname'          : 'by name', 
        'sortkind'          : 'by kind', 
        'sortsize'          : 'by size',
        'sortdate'          : 'by date',

        /********************************** messages **********************************/
        'confirmReq'      : 'Confirmation required',
        'confirmRm'       : 'Are you sure you want to remove files?<br/>This cannot be undone!',
        'confirmRepl'     : 'Replace old file with new one?',
        'apllyAll'        : 'Apply to all',
        'name'            : 'Name',
        'size'            : 'Size',
        'perms'           : 'Permissions',
        'modify'          : 'Modified',
        'kind'            : 'Kind',
        'read'            : 'read',
        'write'           : 'write',
        'noaccess'        : 'no access',
        'and'             : 'and',
        'unknown'         : 'unknown',
        'selectall'       : 'Select all files',
        'selectfiles'     : 'Select file(s)',
        'selectffile'     : 'Select first file',
        'selectlfile'     : 'Select last file',
        'viewlist'        : 'List view',
        'viewicons'       : 'Icons view',
        'places'          : 'Places',
        'calc'            : 'Calculate', 
        'path'            : 'Path',
        'aliasfor'        : 'Alias for',
        'locked'          : 'Locked',
        'dim'             : 'Dimensions',
        'files'           : 'Files',
        'folders'         : 'Folders',
        'items'           : 'Items',
        'yes'             : 'yes',
        'no'              : 'no',
        'link'            : 'Link',
        'searcresult'     : 'Search results',  
        'selected'        : 'selected items',
        'about'           : 'About',
        'shortcuts'       : 'Shortcuts',
        'help'            : 'Help',
        'webfm'           : 'Web file manager',
        'ver'             : 'Version',
        'protocol'        : 'protocol version',
        'homepage'        : 'Project home',
        'docs'            : 'Documentation',
        'github'          : 'Fork us on Github',
        'twitter'         : 'Follow us on twitter',
        'facebook'        : 'Join us on facebook',
        'team'            : 'Team',
        'chiefdev'        : 'chief developer',
        'developer'       : 'developer',
        'contributor'     : 'contributor',
        'maintainer'      : 'maintainer',
        'translator'      : 'translator',
        'icons'           : 'Icons',
        'dontforget'      : 'and don\'t forget to take your towel',
        'shortcutsof'     : 'Shortcuts disabled',
        'dropFiles'       : 'Drop files here',
        'or'              : 'or',
        'selectForUpload' : 'Select files to upload',
        'moveFiles'       : 'Move files',
        'copyFiles'       : 'Copy files',
        'rmFromPlaces'    : 'Remove from places',
        'untitled folder' : 'untitled folder',
        'untitled file.txt' : 'untitled file.txt',
        'aspectRatio'     : 'Aspect ratio',
        'scale'           : 'Scale',
        'width'           : 'Width',
        'height'          : 'Height',
        'mode'            : 'Mode',
        'resize'          : 'Resize',
        'crop'            : 'Crop',
        'rotate'          : 'Rotate',
        'rotate-cw'       : 'Rotate 90 degrees CW',
        'rotate-ccw'      : 'Rotate 90 degrees CCW',
        'degree'          : 'Degree',

        /********************************** mimetypes **********************************/
        'kindUnknown'     : 'Unknown',
        'kindFolder'      : 'Folder',
        'kindAlias'       : 'Alias',
        'kindAliasBroken' : 'Broken alias',
        // applications
        'kindApp'         : 'Application',
        'kindPostscript'  : 'Postscript document',
        'kindMsOffice'    : 'Microsoft Office document',
        'kindMsWord'      : 'Microsoft Word document',
        'kindMsExcel'     : 'Microsoft Excel document',
        'kindMsPP'        : 'Microsoft Powerpoint presentation',
        'kindOO'          : 'Open Office document',
        'kindAppFlash'    : 'Flash application',
        'kindPDF'         : 'Portable Document Format (PDF)',
        'kindTorrent'     : 'Bittorrent file',
        'kind7z'          : '7z archive',
        'kindTAR'         : 'TAR archive',
        'kindGZIP'        : 'GZIP archive',
        'kindBZIP'        : 'BZIP archive',
        'kindZIP'         : 'ZIP archive',
        'kindRAR'         : 'RAR archive',
        'kindJAR'         : 'Java JAR file',
        'kindTTF'         : 'True Type font',
        'kindOTF'         : 'Open Type font',
        'kindRPM'         : 'RPM package',
        // texts
        'kindText'        : 'Text document',
        'kindTextPlain'   : 'Plain text',
        'kindPHP'         : 'PHP source',
        'kindCSS'         : 'Cascading style sheet',
        'kindHTML'        : 'HTML document',
        'kindJS'          : 'Javascript source',
        'kindRTF'         : 'Rich Text Format',
        'kindC'           : 'C source',
        'kindCHeader'     : 'C header source',
        'kindCPP'         : 'C++ source',
        'kindCPPHeader'   : 'C++ header source',
        'kindShell'       : 'Unix shell script',
        'kindPython'      : 'Python source',
        'kindJava'        : 'Java source',
        'kindRuby'        : 'Ruby source',
        'kindPerl'        : 'Perl script',
        'kindSQL'         : 'SQL source',
        'kindXML'         : 'XML document',
        'kindAWK'         : 'AWK source',
        'kindCSV'         : 'Comma separated values',
        'kindDOCBOOK'     : 'Docbook XML document',
        // images
        'kindImage'       : 'Image',
        'kindBMP'         : 'BMP image',
        'kindJPEG'        : 'JPEG image',
        'kindGIF'         : 'GIF Image',
        'kindPNG'         : 'PNG Image',
        'kindTIFF'        : 'TIFF image',
        'kindTGA'         : 'TGA image',
        'kindPSD'         : 'Adobe Photoshop image',
        'kindXBITMAP'     : 'X bitmap image',
        'kindPXM'         : 'Pixelmator image',
        // media
        'kindAudio'       : 'Audio media',
        'kindAudioMPEG'   : 'MPEG audio',
        'kindAudioMPEG4'  : 'MPEG-4 audio',
        'kindAudioMIDI'   : 'MIDI audio',
        'kindAudioOGG'    : 'Ogg Vorbis audio',
        'kindAudioWAV'    : 'WAV audio',
        'AudioPlaylist'   : 'MP3 playlist',
        'kindVideo'       : 'Video media',
        'kindVideoDV'     : 'DV movie',
        'kindVideoMPEG'   : 'MPEG movie',
        'kindVideoMPEG4'  : 'MPEG-4 movie',
        'kindVideoAVI'    : 'AVI movie',
        'kindVideoMOV'    : 'Quick Time movie',
        'kindVideoWM'     : 'Windows Media movie',
        'kindVideoFlash'  : 'Flash movie',
        'kindVideoMKV'    : 'Matroska movie',
        'kindVideoOGG'    : 'Ogg movie'
    }
  }
}
