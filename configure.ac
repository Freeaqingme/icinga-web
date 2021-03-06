#                                               -*- Autoconf -*-
# Process this file with autoconf to produce a configure script.

# include some meta
m4_include([etc/make/version.m4])

# Which version of AC
AC_PREREQ(2.61)

# Init project
AC_INIT(icinga-web, [ICINGA_VERSION], [dev.icinga.org])

# Release date
RELEASE_DATE=ICINGA_RELEASE_DATE

AC_PREFIX_DEFAULT(/usr/local/icinga-web)

if test "x$prefix" = "xNONE" ; then
    installDir="/usr/local/icinga-web"
    prefix=$installDir
else
    installDir=$prefix 
fi

# Checks for programs.
AC_PROG_INSTALL
AC_PROG_GREP
AC_PROG_SED

# Extract version parts
ACICINGA_EXTRACT_VERSION([VERSION_MAJOR],[VERSION_MINOR],[VERSION_PATCH],[VERSION_EXTEN])

AC_SUBST(VERSION_MAJOR)
AC_SUBST(VERSION_MINOR)
AC_SUBST(VERSION_PATCH)
AC_SUBST(VERSION_EXTEN)
AC_SUBST(RELEASE_DATE)

# Check for php
AC_ARG_VAR([PHP],[php cli binary])
ACICINGA_CHECK_BIN([PHP], [php])

# Check for mysql
# We don't need the client anymore, so this is commented out
# AC_ARG_VAR([MYSQL],[mysql client binary])
# ACICINGA_CHECK_BIN([MYSQL], [mysql])

# Check for phing - not required in normal non-dev installations
AC_ARG_VAR([PHING],[phing build tool])
ACICINGA_CHECK_BIN([PHING], [phing])

# Checks for libraries.

# Checks for header files.

# Checks for typedefs, structures, and compiler characteristics.

# Checks for library functions.
ACICINGA_CHECK_PHP_MODULE([sockets xsl xml json])
# Define install options

# Meta option
AC_ARG_WITH([app_name],
    AS_HELP_STRING([--with-app-name=NAME], [Application name (default Icinga)]),
    app_name=$withval,
    app_name=Icinga
)

# Users for webfiles
AC_ARG_WITH([web_user],
    AS_HELP_STRING([--with-web-user=USER], [username for web writable files (default www-data)]),
    web_user=$withval,
    ACICINGA_USER_GUESS([www wwwrun www-data apache httpd nobody],[web_user],[www-data])
)

AC_ARG_WITH([web_group],
    AS_HELP_STRING([--with-web-group=GROUP], [group for web writable files (default www-data)]),
    web_group=$withval,
    ACICINGA_GROUP_GUESS([www www-data apache httpd nogroup nobody],[web_group], [www-data])
)

AC_ARG_WITH([web_path],
    AS_HELP_STRING([--with-web-path=PATH], [web sub path (default /icinga-web)]),
    web_path=$withval,
    web_path=/icinga-web
)

AC_ARG_WITH([web_absolute_path],
    AS_HELP_STRING([--with-web-absolute-path=PATH], [absolute path to pub (default %core.root_dir%/pub)]),
    web_absolute_path=$withval,
    web_absolute_path=%core.root_dir%/pub
)

AC_ARG_WITH([web_apache_path],
    AS_HELP_STRING([--with-web-apache-path=PATH], [Include folder apache2 (default /etc/apache2/conf.d]),
    web_apache_path=$withval,
    web_apache_path=ACICINGA_PATH_GUESS([/etc/httpd/conf.d /etc/apache2/conf.d /etc/apache/conf.d], [web_apache_path], [/etc/apache2/conf.d])
)

AC_ARG_WITH([clearcache_path],
    AS_HELP_STRING([--with-clearcache-path=PATH], [Path to install the clearcache script]),
    clearcache_bin_path=$withval,
    clearcache_bin_path=$prefix/bin
)

AC_ARG_WITH([bin_user],
    AS_HELP_STRING([--with-bin-user=USER], [user for all other files (default root)]),
    bin_user=$withval,
    bin_user=root
)

AC_ARG_WITH([bin_group],
    AS_HELP_STRING([--with-bin-group=GROUP], [group for all other files (default bin)]),
    bin_group=$withval,
    bin_group=bin
)

# Web database switches
AC_ARG_WITH([db_type],
    AS_HELP_STRING([--with-db-type=DBTYPE], [Type of dbms (default mysql)]),
    db_type=$withval,
    db_type=mysql
)

AC_ARG_WITH([db_host],
    AS_HELP_STRING([--with-db-host=HOST], [Host of dbms (default localhost)]),
    db_host=$withval,
    db_host=localhost
)

AC_ARG_WITH([db_port],
    AS_HELP_STRING([--with-db-port=PORT], [Port of the dbms (default 3306)]),
    db_port=$withval,
    db_port=3306
)

AC_ARG_WITH([db_name],
    AS_HELP_STRING([--with-db-name=DBNAME], [DB name for icinga (default icinga_web)]),
    db_name=$withval,
    db_name=icinga_web
)

ACICINGA_ESCAPE_DBNAME([db_name])

AC_ARG_WITH([db_user],
    AS_HELP_STRING([--with-db-user=USER], [DB user for icinga (default icinga_web)]),
    db_user=$withval,
    db_user=icinga_web
)

AC_ARG_WITH([db_pass],
    AS_HELP_STRING([--with-db-pass=PASS], [DB pass for icinga (default icinga_web)]),
    db_pass=$withval,
    db_pass=icinga_web
)

AC_ARG_WITH([db_socket],
    AS_HELP_STRING([--with-db-socket=SOCKET], [DB path to unix socket (default /tmp/mysql.sock)]),
    db_socket=$withval,
    db_socket=/tmp/mysql.sock
)

# Configure the icinga-api

AC_ARG_WITH([api_type],
    AS_HELP_STRING([--with-api-type=APICON], [API type (default CONNECTION_IDO)]),
    api_type=$withval,
    api_type=CONNECTION_IDO
)

AC_ARG_WITH([api_subtype],
    AS_HELP_STRING([--with-api-subtype=TYPE], [DB driver or network connection]),
    api_subtype=$withval,
    api_subtype=mysql
)

AC_ARG_WITH([api_host],
    AS_HELP_STRING([--with-api-host=HOST], [Host to connect (DB or other) (default localhost)]),
    api_host=$withval,
    api_host=localhost
)

AC_ARG_WITH([api_port],
    AS_HELP_STRING([--with-api-port=PORT], [Port for connection (default 3306)]),
    api_port=$withval,
    api_port=3306
)

AC_ARG_WITH([api_socket],
    AS_HELP_STRING([--with-api-socket=PATH], [Path to socket (default none)]),
    api_socket=$withval,
    api_socket=
)

AC_ARG_WITH([api_db_user],
    AS_HELP_STRING([--with-api-db-user=USER], [DB username (default icinga)]),
    api_db_user=$withval,
    api_db_user=icinga
)

AC_ARG_WITH([api_db_pass],
    AS_HELP_STRING([--with-api-db-pass=PASS], [DB password (default icinga)]),
    api_db_pass=$withval,
    api_db_pass=icinga
)

AC_ARG_WITH([api_db_name],
    AS_HELP_STRING([--with-api-db-name=DBNAME], [DB name (default icinga)]),
    api_db_name=$withval,
    api_db_name=icinga
)

AC_ARG_WITH([api_db_prefix],
    AS_HELP_STRING([--with-api-db-prefix=PREFIX], [DB table prefiy (default icinga_)]),
    api_db_prefix=$withval,
    api_db_prefix=icinga_
)

AC_ARG_WITH([api_cmd_file],
    AS_HELP_STRING([--with-api-cmd-file=PATH], [Icinga command file (default /usr/local/icinga/var/rw/icinga.cmd)]),
    api_cmd_file=$withval,
    api_cmd_file=/usr/local/icinga/var/rw/icinga.cmd
)

AC_ARG_WITH([api_cmd_instance],
    AS_HELP_STRING([--with-api-cmd-instance=NAME], [Icinga default command instance name (default "default")]),
    api_cmd_instance=$withval,
    api_cmd_instance=default
)

AC_ARG_WITH([devel_mode],
    AS_HELP_STRING([--with-devel-mode], [Web devel mode (disable caching)]),
    devel_mode=$withval,
    devel_mode=no
)

AC_ARG_WITH([sla_default_timespan],
    AS_HELP_STRING([--with-sla-default-timespan=TIMESPAN], [The timespan used for non-detailed sla overviews]),
    sla_default_timespan=$withval,
    sla_default_timespan="-1 month"
)

AC_ARG_WITH([enable_sla],
    AS_HELP_STRING([--with-enable-sla], [Enable SLA support]),
    enable_sla=$withval,
    enable_sla=false
)

# Configuration location
AC_ARG_WITH([conf_dir],
    AS_HELP_STRING([--with-conf-dir=PATH], [Folder where to store custom user configurations (default etc/conf.d/)]),
    web_conf_dir=$withval,
    web_conf_dir=$prefix/etc/conf.d   
)

# Log location
AC_ARG_WITH([log_dir],
    AS_HELP_STRING([--with-log-dir=PATH], [Folder where to store log files (default log/)]),
    web_log_dir=$withval,
    web_log_dir=$prefix/log 
)

# Agavi caching directory
AC_ARG_WITH([cache_dir],
    AS_HELP_STRING([--with-cache-dir=PATH], [Directory to store agavi cache files (default app/cache/)]),
    web_cache_dir=$withval,
    web_cache_dir=$prefix/app/cache
)

# Jasper temporary directory for downloads
AC_ARG_WITH([reporting_tmp_dir],
    AS_HELP_STRING([--with-reporting-tmp-dir=PATH], [Directory to store temporary files for jasper (default app/modules/Reporting/data/tmp)]),
    reporting_tmp_dir=$withval,
    reporting_tmp_dir=$prefix/app/modules/Reporting/data/tmp/
)

# icinga core options
AC_ARG_WITH([icinga_objects_dir],
    AS_HELP_STRING([--with-icinga-objects-dir=PATH], [Path Icinga configuration items]),
    icinga_objects_dir=$withval,
    icinga_objects_dir=/usr/local/icinga/etc/objects
)

ACICINGA_RESOURCE_EXISTS([icinga_objects_dir], [$icinga_objects_dir])

AC_ARG_WITH([icinga_bin],
    AS_HELP_STRING([--with-icinga-bin=PATH], [Icinga core binary]),
    icinga_bin=$withval,
    icinga_bin=/usr/local/icinga/bin/icinga
)

ACICINGA_RESOURCE_EXISTS([icinga], [$icinga_bin])

AC_ARG_WITH([icinga_cfg],
    AS_HELP_STRING([--with-icinga-cfg=PATH], [Icinga core main configuration file]),
    icinga_cfg=$withval,
    icinga_cfg=/usr/local/icinga/etc/icinga.cfg
)

ACICINGA_RESOURCE_EXISTS([icinga_config], [$icinga_cfg])

# Testing switches
AC_ARG_WITH([phpunit],
    AS_HELP_STRING([--with-phpunit=BINARY], [Path to phpunit script]),
    PHPUNIT=$withval,
    PHPUNIT=phpunit
)

# Supress warnings to the user
#ACICINGA_CHECK_BIN([PHPUNIT], [$phpunit])

AC_ARG_WITH([phpcs],
    AS_HELP_STRING([--with-phpcs=BINARY], [Path to phpcs script]),
    PHPCS=$withval,
    PHPCS=phpcs
)

# Supress warnings ro the user
#ACICINGA_CHECK_BIN([PHPCS], [$phpcs])

# Custom vars
INSTALL_OPTS="-o $bin_user -g $bin_group"
INSTALL_OPTS_WEB="-o $web_user -g $web_group"
INSTALL_OPTS_CACHE="-o $web_user -g $web_group"

flag_caching=true
flag_debug=false

CFLAGS=""

ACICINGA_DEVEL_MODE()

# Substitutions
AC_SUBST(app_name)
AC_SUBST(web_user)
AC_SUBST(web_group)
AC_SUBST(web_path)
AC_SUBST(web_absolute_path)
AC_SUBST(web_apache_path)
AC_SUBST(clearcache_bin_path)
AC_SUBST(bin_user)
AC_SUBST(bin_group)

AC_SUBST(db_type)
AC_SUBST(db_host)
AC_SUBST(db_port)
AC_SUBST(db_name)
AC_SUBST(db_user)
AC_SUBST(db_pass)
AC_SUBST(db_socket)

AC_SUBST(api_type)
AC_SUBST(api_subtype)
AC_SUBST(api_host)
AC_SUBST(api_port)
AC_SUBST(api_socket)
AC_SUBST(api_db_user)
AC_SUBST(api_db_pass)
AC_SUBST(api_db_name)
AC_SUBST(api_db_prefix)
AC_SUBST(api_cmd_file)
AC_SUBST(api_cmd_instance)

AC_SUBST(enable_sla)
AC_SUBST(sla_default_timespan)

AC_SUBST(CFLAGS)
AC_SUBST(PHP)
AC_SUBST(MYSQL)
AC_SUBST(PHING)
AC_SUBST(PHPUNIT)
AC_SUBST(PHPCS)
AC_SUBST(INSTALL_OPTS)
AC_SUBST(INSTALL_OPTS_WEB)
AC_SUBST(INSTALL_OPTS_CACHE)
AC_SUBST(flag_caching)
AC_SUBST(flag_debug)

AC_SUBST(web_log_dir)
AC_SUBST(web_conf_dir)
AC_SUBST(web_cache_dir)
AC_SUBST(reporting_tmp_dir)

AC_SUBST(icinga_api)
AC_SUBST(icinga_objects_dir)
AC_SUBST(icinga_bin)
AC_SUBST(icinga_cfg)

AC_CONFIG_FILES([
    Makefile
    lib/Makefile
    lib/icingaScheduler/config.php
    lib/icingaScheduler/Makefile
    lib/jit/Makefile
    lib/ext3/Makefile
    lib/agavi/Makefile
    lib/phpseclib/Makefile
    lib/doctrine/Makefile
    lib/jsgettext/Makefile
    pub/Makefile
    etc/Makefile
    bin/Makefile
    doc/Makefile
    app/Makefile
    app/config.php
    app/config/databases.xml
    app/config/icinga.xml
    app/config/logging.xml
    app/config/settings.xml
    app/config/translation.xml
    app/config/factories.xml
    app/modules/Api/config/access.xml
    app/modules/Api/config/module.xml
    app/modules/AppKit/config/module.xml
    app/modules/AppKit/config/auth.xml
    app/modules/Config/config/module.xml
    app/modules/Reporting/config/module.xml
    app/modules/Web/config/module.xml
    etc/build.properties
    tests/phpunit/test.properties
    etc/apache2/icinga-web.conf
    etc/scheduler/icingaCron
    bin/clearcache.sh
    etc/conf.d/access.xml
    etc/conf.d/databases.xml
    etc/conf.d/Makefile
    etc/conf.d/sla.xml
])

AC_OUTPUT


echo ""
echo "icinga-web successfully configured!"
echo ""
echo "Please proceed with make to install your icinga-web instance:"
echo ""
echo " * make               Some general hints about make targets"
echo " * make install       Install a new instance of icinga-web"
echo " * make upgrade       Upgrades an existing installation:"
echo "                      keep site config files untouched!"
echo ""

# [EOF]
