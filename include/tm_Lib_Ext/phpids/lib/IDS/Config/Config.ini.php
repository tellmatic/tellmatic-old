; <?php die(); ?>

; PHPIDS Config.ini

; General configuration settings


[General]

    ; basic settings - customize to make the PHPIDS work at all
    filter_type     = xml
    
    base_path       = /full/path/to/IDS/ 
    use_base_path   = false
    
    filter_path     = default_filter.xml
    tmp_path        = tmp
    scan_keys       = false
    
    ; in case you want to use a different HTMLPurifier source, specify it here
    ; By default, those files are used that are being shipped with PHPIDS
    HTML_Purifier_Path	= vendors/htmlpurifier/HTMLPurifier.auto.php
    HTML_Purifier_Cache = vendors/htmlpurifier/HTMLPurifier/DefinitionCache/Serializer
    
    ; define which fields contain html and need preparation before 
    ; hitting the PHPIDS rules (new in PHPIDS 0.5)
    html[]          = REQUEST.body_text

    
    ; define which fields contain JSON data and should be treated as such 
    ; for fewer false positives (new in PHPIDS 0.5.3)
    json[]          = POST.__jsondata

    ; define which fields shouldn't be monitored (a[b]=c should be referenced via a.b)
    exceptions[]    = REQUEST.body_text
    exceptions[]    = POST.body_text

    exceptions[]    = REQUEST.body
    exceptions[]    = POST.body

    exceptions[]    = REQUEST.subject
    exceptions[]    = POST.subject

    ; you can use regular expressions for wildcard exceptions - example: /.*foo/i

    ; PHPIDS should run with PHP 5.1.2 but this is untested - set 
    ; this value to force compatibilty with minor versions
    min_php_version = 5.1.6

; If you use the PHPIDS logger you can define specific configuration here

[Logging]

    ; file logging
    path            = tmp/phpids_log.txt

    ; email logging

    ; note that enabling safemode you can prevent spam attempts,
    ; see documentation
    recipients[]    = info@tellmatic.org
    subject         = "PHPIDS @ Tellmatic detected an intrusion attempt!"
    header			= "From: <Tellmatic-PHPIDS> info@tellmatic.org"
    envelope        = ""
    safemode        = true
    urlencode       = true
    allowed_rate    = 15

