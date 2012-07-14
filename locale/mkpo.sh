######!/bin/bash
clear
LANGS="de en es it nl pt"
#LANGS="nl"
domain="tellmatic"
for lang in $LANGS; do
    echo $lang
#mkdir -p ./$lang/LC_MESSAGES

#	--no-location \
#	--join-existing \
#	--sort-by-file \
#	-o ./$lang/LC_MESSAGES/$domain.po \
    xgettext \
	-i \
	-o ./$domain-$lang.po \
	--keyword=___ \
	-C \
	--from-code="UTF-8" \
	--width=1024 \
	--join-existing \
	--no-wrap \
	../*.php \
	../include/install/*.php \
	../include/*.php

#	../include/*.inc.php

##    msgfmt ./$lang/LC_MESSAGES/$domain.po --output-file=./$lang/LC_MESSAGES/$domain.mo
#    msgfmt ./$domain-$lang.po --output-file=./$lang/LC_MESSAGES/$domain.mo

done;
