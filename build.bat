@ECHO OFF

IF EXIST D:\RunTime\php7\runtime.bat (
    CALL D:\RunTime\php7\runtime set
)

::进入当前项目
CLS && CD /d %~dp0

CALL php -f build.php

CMD /k
