﻿/**
 * German translation
 * @author JPG & Mace <dev@flying-datacenter.de>
 * @author tora60 from pragmaMx.org
 * @version 2013-05-01
 */
if (elFinder && elFinder.prototype && typeof(elFinder.prototype.i18) == 'object') {
	elFinder.prototype.i18.de = {
		translator : 'JPG & Mace &lt;dev@flying-datacenter.de&gt;, tora60 from pragmaMx.org',
		language   : 'Deutsch',
		direction  : 'ltr',
		dateFormat : 'd. M. Y h:i', // 13. Mai 2012 05:27
		fancyDateFormat : '$1 h:i', // will produce smth like: Today 12:25 PM
		messages   : {
			
			/********************************** errors **********************************/
			'error'                : 'Fehler',
			'errUnknown'           : 'Unbekannter Fehler.',
			'errUnknownCmd'        : 'Unbekannter Befehl.',
			'errJqui'              : 'UngГјltige jQuery UI Konfiguration. Die Komponenten Selectable, draggable und droppable mГјssen inkludiert sein.',
			'errNode'              : 'FГјr elFinder muss das DOM Element erstellt werden.',
			'errURL'               : 'UngГјltige elFinder Konfiguration! Die URL Option nicht gesetzt.',
			'errAccess'            : 'Zugriff verweigert.',
			'errConnect'           : 'Verbindung zum Backend fehlgeschlagen',
			'errAbort'             : 'Verbindung abgebrochen.',
			'errTimeout'           : 'ZeitГјberschreitung der Verbindung.',
			'errNotFound'          : 'Backend nicht gefunden.',
			'errResponse'          : 'UngГјltige Backend Antwort.',
			'errConf'              : 'UngГјltige Backend Konfiguration.',
			'errJSON'              : 'PHP JSON Modul nicht vorhanden.',
			'errNoVolumes'         : 'Lesbare Volumes nicht vorhanden.',
			'errCmdParams'         : 'UngГјltige Parameter fГјr Befehl: "$1".',
			'errDataNotJSON'       : 'Daten nicht im JSON Format.',
			'errDataEmpty'         : 'Daten sind leer.',
			'errCmdReq'            : 'Backend Anfrage benГ¶tigt Befehl.',
			'errOpen'              : 'Kann "$1" nicht Г¶ffnen',
			'errNotFolder'         : 'Objekt ist kein Ordner.',
			'errNotFile'           : 'Objekt ist keine Datei.',
			'errRead'              : 'Kann "$1" nicht Г¶ffnen.',
			'errWrite'             : 'Kann nicht in "$1" schreiben.',
			'errPerm'              : 'Zugriff verweigert.',
			'errLocked'            : '"$1" ist gelockt und kann nicht umbenannt, verschoben oder gelГ¶scht werden.',
			'errExists'            : 'Die Datei "$1" existiert bereits.',
			'errInvName'           : 'UngГјltiger Datei Name.',
			'errFolderNotFound'    : 'Ordner nicht gefunden.',
			'errFileNotFound'      : 'Datei nicht gefunden.',
			'errTrgFolderNotFound' : 'Zielordner "$1" nicht gefunden.',
			'errPopup'             : 'Der Browser hat das Pop-Up-Fenster unterbunden. Um die Datei zu Г¶ffnen, Pop-Ups in den Browser Einstellungen aktivieren.',
			'errMkdir'             : 'Kann Ordner "$1" nicht erstellen.',
			'errMkfile'            : 'Kann Datei "$1" nicht erstellen.',
			'errRename'            : 'Kann "$1" nicht umbenennen.',
			'errCopyFrom'          : 'Kopieren von Dateien von "$1" nicht erlaubt.',
			'errCopyTo'            : 'Kopieren von Dateien nach "$1" nicht erlaubt.',
			'errUpload'            : 'Upload Fehler.',
			'errUploadFile'        : 'Kann "$1" nicht hochladen.',
			'errUploadNoFiles'     : 'Keine Dateien zum Hochladen gefunden.',
			'errUploadTotalSize'   : 'Daten Гјberschreiten die MaximalgrГ¶Гџe.',
			'errUploadFileSize'    : 'Die Datei Гјberschreitet die MaximalgrГ¶Гџe',
			'errUploadMime'        : 'Dateityp nicht zulГ¤ssig.',
			'errUploadTransfer'    : '"$1" Transfer Fehler.',
			'errNotReplace'        : 'Das Objekt "$1" existiert bereits an dieser Stelle und kann nicht durch ein Objekt eines anderen Typs ersetzt werden.',
			'errReplace'           : 'Kann "$1" nicht ersetzen.',
			'errSave'              : 'Kann "$1" nicht speichern.',
			'errCopy'              : 'Kann "$1" nicht kopieren.',
			'errMove'              : 'Kann "$1" nicht verschieben.',
			'errCopyInItself'      : '"$1" kann sich nicht in sich selbst kopieren.',
			'errRm'                : 'Kann "$1" nicht enfernen.',
			'errRmSrc'             : 'Kann Quelldatei(en) nicht entfernen.',
			'errExtract'           : 'Kann "$1" nicht entpacken .',
			'errArchive'           : 'Archiv konnte nicht erstellt werden.',
			'errArcType'           : 'Archivtyp nicht untersГјtzt.',
			'errNoArchive'         : 'Bei der Datei handelt es nicht um ein Archiv oder der Archivtyp nicht unterstГјtz.',
			'errCmdNoSupport'      : 'Das Backend unterstГјtz diesen Befehl nicht.',
			'errReplByChild'       : 'Der Ordner вЂњ$1вЂќ kann nicht durch etwas ersetzt werden, das ihn selbst enthГ¤lt.',
			'errArcSymlinks'       : 'Aus SicherheitsgrГјnden ist es verboten, ein Archiv mit symbolischen Links zu extrahieren.',
			'errArcMaxSize'        : 'Die Archiv Dateien Гјbersteigen die maximal erlaubte GrГ¶Гџe.',
			'errResize'            : 'GrГ¶Гџe von "$1" kann nicht geГ¤ndert werden.',
			'errUsupportType'      : 'Nicht unterstГјtzter Dateityp.',
			'errNotUTF8Content'    : 'Die Datei "$1" ist nicht im UTF-8 Format und kann nicht editiert werden.',
			'errNetMount'          : 'Verbindung mit "$1" nicht mГ¶glich.',
			'errNetMountNoDriver'  : 'Nicht unterstГјtztes Protokoll.',
			'errNetMountFailed'    : 'Verbindung fehlgeschlagen.',
			'errNetMountHostReq'   : 'Host benГ¶tigz.',
			'errSessionExpires'    : 'Ihre Sitzung ist aufgrund von InaktivitГ¤t abgelaufen',
			'errCreatingTempDir'   : 'Erstellung des temporГ¤ren Ordners nicht mГ¶glich: "$1"',
			'errFtpDownloadFile'   : 'Download der Datei Гјber FTP nicht mГ¶glich: "$1"',
			'errFtpUploadFile'     : 'Upload der Datei zu FTP nicht mГ¶glich: "$1"',
			'errFtpMkdir'          : 'Erstellung des Remote-Ordners auf FTP nicht mГ¶glich: "$1"',
			'errArchiveExec'       : 'Fehler bei der Archivierung der Dateien: "$1"',
			'errExtractExec'       : 'Fehler beim Extrahieren der Dateien: "$1"',

			/******************************* commands names ********************************/
			'cmdarchive'   : 'Archiv erstellen',
			'cmdback'      : 'ZurГјck',
			'cmdcopy'      : 'Kopieren',
			'cmdcut'       : 'Ausschreiden',
			'cmddownload'  : 'Herunterladen',
			'cmdduplicate' : 'Duplizieren',
			'cmdedit'      : 'Datei bearbeiten',
			'cmdextract'   : 'Archiv entpacken',
			'cmdforward'   : 'VorwГ¤rts',
			'cmdgetfile'   : 'Datei auswГ¤hlen',
			'cmdhelp'      : 'Гјber diese Software',
			'cmdhome'      : 'Startordner',
			'cmdinfo'      : 'Informationen',
			'cmdmkdir'     : 'Neuer Ordner',
			'cmdmkfile'    : 'Neue Textdatei',
			'cmdopen'      : 'Г¶ffnen',
			'cmdpaste'     : 'EinfГјgen',
			'cmdquicklook' : 'Vorschau',
			'cmdreload'    : 'Neuladen',
			'cmdrename'    : 'Umbenennen',
			'cmdrm'        : 'LГ¶schen',
			'cmdsearch'    : 'Suchen',
			'cmdup'        : 'In Гјbergeordneten Ordner wechseln',
			'cmdupload'    : 'Datei hochladen',
			'cmdview'      : 'Ansehen',
			'cmdresize'    : 'GrГ¶Гџe Г¤ndern & drehen',
			'cmdsort'      : 'Sortieren',
			'cmdnetmount'  : 'Verbinde mit Netzwerkspeicher',
			
			/*********************************** buttons ***********************************/ 
			'btnClose'  : 'SchlieГџen',
			'btnSave'   : 'Speichern',
			'btnRm'     : 'Entfernen',
			'btnApply'  : 'Anwenden',
			'btnCancel' : 'Abbrechen',
			'btnNo'     : 'Nein',
			'btnYes'    : 'Ja',
			'btnMount'  : 'Verbinden',
			/******************************** notifications ********************************/
			'ntfopen'     : 'Г¶ffne Ordner',
			'ntffile'     : 'Г¶ffne Datei',
			'ntfreload'   : 'Ordnerinhalt neu',
			'ntfmkdir'    : 'Erstelle Ordner',
			'ntfmkfile'   : 'Erstelle Dateien',
			'ntfrm'       : 'LГ¶sche Dateien',
			'ntfcopy'     : 'Kopiere Dateien files',
			'ntfmove'     : 'Verschiebe Dateien',
			'ntfprepare'  : 'Kopiervorgang initialisieren',
			'ntfrename'   : 'Benenne Dateien um',
			'ntfupload'   : 'Dateien hochladen',
			'ntfdownload' : 'Dateien herunterladen',
			'ntfsave'     : 'Speichere Datei',
			'ntfarchive'  : 'Erstelle Archiv',
			'ntfextract'  : 'Entpacke Dateien',
			'ntfsearch'   : 'Suche',
			'ntfresize'   : 'BildgrГ¶Гџen Г¤ndern',
			'ntfsmth'     : 'Bin beschГ¤ftigt',
			'ntfloadimg'  : 'Bild laden',
			'ntfnetmount' : 'Mit Netzwerkspeicher verbinden',
			
			/************************************ dates **********************************/
			'dateUnknown' : 'unbekannt',
			'Today'       : 'Heute',
			'Yesterday'   : 'Gestern',
			'Jan'         : 'Jan',
			'Feb'         : 'Feb',
			'Mar'         : 'MГ¤r',
			'Apr'         : 'Apr',
			'May'         : 'Mai',
			'Jun'         : 'Jun',
			'Jul'         : 'Jul',
			'Aug'         : 'Aug',
			'Sep'         : 'Sep',
			'Oct'         : 'Okt',
			'Nov'         : 'Nov',
			'Dec'         : 'Dez',

			/******************************** sort variants ********************************/
			'sortname'         : 'nach Name',
			'sortkind'         : 'nach Typ',
			'sortsize'         : 'nach GrГ¶Гџe',
			'sortdate'         : 'nach Datum',
			'sortFoldersFirst' : 'Ordner zuerst',

			/********************************** messages **********************************/
			'confirmReq'      : 'BestГ¤tigung BenГ¶tigt',
			'confirmRm'       : 'Sollen die Dateien gelГ¶scht werden?<br/>Dies kann nicht rГјckgГ¤ngig gemacht werden!',
			'confirmRepl'     : 'Datei ersetzen?',
			'apllyAll'        : 'Alles bestГ¤tigen',
			'name'            : 'Name',
			'size'            : 'GrГ¶Гџe',
			'perms'           : 'Berechtigungen',
			'modify'          : '&Auml;nderungsdatum',
			'kind'            : 'Typ',
			'read'            : 'lesen',
			'write'           : 'schreiben',
			'noaccess'        : 'Kein Zugriff',
			'and'             : 'und',
			'unknown'         : 'unbekannt',
			'selectall'       : 'Alle Dateien auswГ¤hlen',
			'selectfiles'     : 'Dateien auswГ¤hlen',
			'selectffile'     : 'Erste Datei auswhГ¤hlen',
			'selectlfile'     : 'Letzte Datei auswГ¤hlen',
			'viewlist'        : 'Spaltenansicht',
			'viewicons'       : 'Symbolansicht',
			'places'          : 'Orte',
			'calc'            : 'Berechne',
			'path'            : 'Pfad',
			'aliasfor'        : 'VerknГјpfund zu',
			'locked'          : 'Gesperrt',
			'dim'             : 'BildgrГ¶Гџe',
			'files'           : 'Dateien',
			'folders'         : 'Ordner',
			'items'           : 'Objekte',
			'yes'             : 'ja',
			'no'              : 'nein',
			'link'            : 'Link',
			'searcresult'     : 'Suchergebnisse',
			'selected'        : 'Objekte ausgewГ¤hlt',
			'about'           : 'Гјber',
			'shortcuts'       : 'Tastenkombinationen',
			'help'            : 'Hilfe',
			'webfm'           : 'Web Datei Manager',
			'ver'             : 'Version',
			'protocolver'     : 'Protokol Version',
			'homepage'        : 'Projekt Website',
			'docs'            : 'Dokumentation',
			'github'          : 'Forke uns auf Github',
			'twitter'         : 'Folge uns auf twitter',
			'facebook'        : 'Begleite uns auf facebook',
			'team'            : 'Team',
			'chiefdev'        : 'Chefentwickler',
			'developer'       : 'Entwickler',
			'contributor'     : 'ГњntersГјtzer',
			'maintainer'      : 'Maintainer',
			'translator'      : 'Гњbersetzer',
			'icons'           : 'Icons',
			'dontforget'      : 'und vergiss dein Handtuch nicht',
			'shortcutsof'     : 'Tastenkombinationen deaktiviert',
			'dropFiles'       : 'Dateien hier ablegen',
			'dropFilesBrowser': 'Verschieben oder EinfГјgen von Dateien aus dem Browser',
			'or'              : 'oder',
			'selectForUpload' : 'Dateien zum Upload auswГ¤hlen',
			'moveFiles'       : 'Dateien verschieben',
			'copyFiles'       : 'Dateien kopieren',
			'rmFromPlaces'    : 'LГ¶sche von Orte',
			'aspectRatio'     : 'SeitenverhГ¤ltnis',
			'scale'           : 'MaГџstab',
			'width'           : 'Breite',
			'height'          : 'HГ¶he',
			'resize'          : 'GrГ¶Гџe Г¤ndern',
			'crop'            : 'Zuschneiden',
			'rotate'          : 'Drehen',
			'rotate-cw'       : 'Drehe 90В° im Uhrzeigersinn',
			'rotate-ccw'      : 'Drehe 90В° gegen den Uhrzeigersinn',
			'degree'          : 'В°',
			'netMountDialogTitle' : 'verbinde Netzwerk Speicher',
			'protocol'            : 'Protokoll',
			'host'                : 'Host',
			'port'                : 'Port',
			'user'                : 'Benutzer',
			'pass'                : 'Passwort',

			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Unbekannt',
			'kindFolder'      : 'Ordner',
			'kindAlias'       : 'VerknГјpfung',
			'kindAliasBroken' : 'Defekte VerknГјpfung',
			// applications
			'kindApp'         : 'Programm',
			'kindPostscript'  : 'Postscript Dokument',
			'kindMsOffice'    : 'Microsoft Office Dokument',
			'kindMsWord'      : 'Microsoft Word Dokument',
			'kindMsExcel'     : 'Microsoft Excel Dokument',
			'kindMsPP'        : 'Microsoft Powerpoint PrГ¤sentation',
			'kindOO'          : 'Open Office Dokument',
			'kindAppFlash'    : 'Flash Programm',
			'kindPDF'         : 'Portables Dokumentenformat (PDF)',
			'kindTorrent'     : 'Bittorrent Datei',
			'kind7z'          : '7z Archiv',
			'kindTAR'         : 'TAR Archiv',
			'kindGZIP'        : 'GZIP Archiv',
			'kindBZIP'        : 'BZIP Archiv',
			'kindZIP'         : 'ZIP Archiv',
			'kindRAR'         : 'RAR Archiv',
			'kindJAR'         : 'Java JAR Datei',
			'kindTTF'         : 'True Type Schrift',
			'kindOTF'         : 'Open Type Schrift',
			'kindRPM'         : 'RPM Paket',
			// texts
			'kindText'        : 'Text Dokument',
			'kindTextPlain'   : 'Text Dokument',
			'kindPHP'         : 'PHP Quelltext',
			'kindCSS'         : 'Cascading Stylesheet',
			'kindHTML'        : 'HTML Dokument',
			'kindJS'          : 'Javascript Quelltext',
			'kindRTF'         : 'Formatierte Textdatei',
			'kindC'           : 'C Quelltext',
			'kindCHeader'     : 'C Header Quelltext',
			'kindCPP'         : 'C++ Quelltext',
			'kindCPPHeader'   : 'C++ Header Quelltext',
			'kindShell'       : 'Unix-Shell-Skript',
			'kindPython'      : 'Python Quelltext',
			'kindJava'        : 'Java Quelltext',
			'kindRuby'        : 'Ruby Quelltext',
			'kindPerl'        : 'Perl Script',
			'kindSQL'         : 'SQL Quelltext',
			'kindXML'         : 'XML Dokument',
			'kindAWK'         : 'AWK Quelltext',
			'kindCSV'         : 'Komma getrennte Daten',
			'kindDOCBOOK'     : 'Docbook XML Dokument',
			// images
			'kindImage'       : 'Bild',
			'kindBMP'         : 'Bitmap Bild',
			'kindJPEG'        : 'JPEG Bild',
			'kindGIF'         : 'GIF Bild',
			'kindPNG'         : 'PNG Bild',
			'kindTIFF'        : 'TIFF Bild',
			'kindTGA'         : 'TGA Bild',
			'kindPSD'         : 'Adobe Photoshop Bild',
			'kindXBITMAP'     : 'X Bitmap Bild',
			'kindPXM'         : 'Pixelmator Bild',
			// media
			'kindAudio'       : 'Audiodatei',
			'kindAudioMPEG'   : 'MPEG Audio',
			'kindAudioMPEG4'  : 'MPEG-4 Audio',
			'kindAudioMIDI'   : 'MIDI Audio',
			'kindAudioOGG'    : 'Ogg Vorbis Audio',
			'kindAudioWAV'    : 'WAV Audio',
			'AudioPlaylist'   : 'MP3 Playlist',
			'kindVideo'       : 'Videodatei',
			'kindVideoDV'     : 'DV Film',
			'kindVideoMPEG'   : 'MPEG Film',
			'kindVideoMPEG4'  : 'MPEG-4 Film',
			'kindVideoAVI'    : 'AVI Film',
			'kindVideoMOV'    : 'Quick Time Film',
			'kindVideoWM'     : 'Windows Media Film',
			'kindVideoFlash'  : 'Flash Film',
			'kindVideoMKV'    : 'Matroska Film',
			'kindVideoOGG'    : 'Ogg Film'
		}
	}
}
