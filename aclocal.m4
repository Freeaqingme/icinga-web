
AC_DEFUN([ACICINGA_USER_GUESS],[
   $2=$3
   for x in $1; do
    AC_MSG_CHECKING([if user $x exists])
     AS_IF([ $GREP -q "^$x:" /etc/passwd ],
           [ AC_MSG_RESULT([found]); $2=$x ; break],
           [ AC_MSG_RESULT([not found]) ])
   done
  ])

AC_DEFUN([ACICINGA_GROUP_GUESS],[
   $2=$3
   for x in $1; do
    AC_MSG_CHECKING([if group $x exists])
     AS_IF([ $GREP -q "^$x:" /etc/group ],
           [ AC_MSG_RESULT([found]); $2=$x ; break],
           [ AC_MSG_RESULT([not found]) ])
   done
])

AC_DEFUN([ACICINGA_CHECK_BIN], [
   AC_PATH_PROG([$1],[$2],[not found])

   AS_IF([ test "$2" == "not found" ],
	 [ AC_MSG_WARN([binary $3 not found in PATH]) ])
    
])

AC_DEFUN([ACICINGA_CHECK_API], [
	AC_MSG_CHECKING([for IcingaApi])
	AS_IF([ test -e $1/IcingaApi.php && $GREP -q "class IcingaApi" $1/IcingaApi.php ],
		[ AC_MSG_RESULT([found])    ],
		[ AC_MSG_WARN([not found]) ])
])

AC_DEFUN([ACICINGA_EXTRACT_VERSION], [
	$1=`echo "$PACKAGE_VERSION" | $SED 's/^\([[0-9]]\+\)\.\([[0-9]]\+\)\.\([[0-9]]\+\)\(\-\(.\+\)\)\?$/\1/g'`
	$2=`echo "$PACKAGE_VERSION" | $SED 's/^\([[0-9]]\+\)\.\([[0-9]]\+\)\.\([[0-9]]\+\)\(\-\(.\+\)\)\?$/\2/g'`
	$3=`echo "$PACKAGE_VERSION" | $SED 's/^\([[0-9]]\+\)\.\([[0-9]]\+\)\.\([[0-9]]\+\)\(\-\(.\+\)\)\?$/\3/g'`
	$4=`echo "$PACKAGE_VERSION" | $SED 's/^\([[0-9]]\+\)\.\([[0-9]]\+\)\.\([[0-9]]\+\)\(\-\(.\+\)\)\?$/\5/g'`
]);