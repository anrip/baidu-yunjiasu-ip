@ECHO OFF

IF EXIST D:\RunTime\php7\runtime.bat (
    CALL D:\RunTime\php7\runtime set
)

::���뵱ǰ��Ŀ
CLS && CD /d %~dp0

CALL php -f build.php

CMD /k
