# $Id$
# Authority: The icinga devel team <icinga-devel at lists.sourceforge.net>
# Upstream: The icinga devel team <icinga-devel at lists.sourceforge.net>
# ExcludeDist: el4 el3

%define revision 2

%define logdir %{_localstatedir}/log/icinga-web
%define cachedir %{_localstatedir}/cache/icinga-web

%if "%{_vendor}" == "suse"
%define apacheconfdir  %{_sysconfdir}/apache2/conf.d
%define apacheuser wwwrun
%define apachegroup www
%endif
%if "%{_vendor}" == "redhat"
%define apacheconfdir  %{_sysconfdir}/httpd/conf.d
%define apacheuser apache
%define apachegroup apache
%endif

Summary: Open Source host, service and network monitoring Web UI
Name: icinga-web
Version: 1.6.2
Release: %{revision}%{?dist}
License: GPLv2
Group: Applications/System
URL: http://www.icinga.org/
BuildArch: noarch
%if "%{_vendor}" == "suse"
AutoReqProv: Off
%endif

# Source0: icinga-web-%{version}.tar.gz
Source0: https://downloads.sourceforge.net/project/icinga/icinga-web/%{version}/icinga-web-%{version}.tar.gz

BuildRoot: %{_tmppath}/%{name}-%{version}-%{release}-root

Requires: perl(Locale::PO)
Requires: php >= 5.2.3
Requires: php-pear
Requires: php-gd
Requires: php-xml
Requires: php-ldap
Requires: php-pdo
Requires: php-dom
%if "%{_vendor}" == "redhat"
Requires: php-common
%endif
%if "%{_vendor}" == "suse"
Requires: php-xsl
Requires: apache2-mod_php5
%endif
Requires: php-spl
Requires: pcre >= 7.6

%description
Icinga Web for Icinga Core, uses Icinga IDOUtils DB as data source.

%prep
%setup -n %{name}-%{version}

%build
%configure \
    --prefix="%{_datadir}/icinga-web" \
    --datadir="%{_datadir}/icinga-web" \
    --datarootdir="%{_datadir}/icinga-web" \
    --sysconfdir="%{_sysconfdir}/icinga-web" \
    --with-conf-dir='%{_sysconfdir}/icinga-web/conf.d' \
    --with-web-user='%{apacheuser}' \
    --with-web-group='%{apachegroup}' \
    --with-api-cmd-file='%{_localstatedir}/icinga/rw/icinga.cmd' \
    --with-log-dir='%{logdir}' \
    --with-cache-dir='%{cachedir}' \
    --with-web-apache-path=%{apacheconfdir}

%install
%{__rm} -rf %{buildroot}
%{__mkdir} -p %{buildroot}/%{apacheconfdir}
%{__mkdir} -p %{buildroot}/%{_bindir}
%{__make} install \
    install-apache-config \
    DESTDIR="%{buildroot}" \
    INSTALL_OPTS="" \
    COMMAND_OPTS="" \
    INSTALL_OPTS_WEB="" \
    INSTALL_OPTS_CACHE="" \
    INIT_OPTS=""

# we only want clearcache.sh prefixed in {_bindir}, generated from configure
%{__mv} %{buildroot}%{_datadir}/icinga-web/bin/clearcache.sh %{buildroot}%{_bindir}/%{name}-clearcache

# wipe the rest of bin/, we don't need prepackage stuff in installed envs
%{__rm} -rf %{buildroot}%{_datadir}/icinga-web/bin

##############################
%pre
##############################

# Add apacheuser in the icingacmd group
# If the group exists, add the apacheuser in the icingacmd group.
# It is not neccessary that icinga-web is installed on the same system as
# icinga and only on systems with icinga installed the icingacmd
# group exists. In all other cases the user used for ssh access has
# to be added to the icingacmd group on the remote icinga server.
getent group icingacmd > /dev/null
if [ $? -eq 0 ]; then
  /usr/sbin/usermod -a -G icingacmd %{apacheuser}
fi

# uncomment if building from git
# %{__rm} -rf %{buildroot}%{_datadir}/icinga-web/.git

##############################
%preun
##############################

##############################
%post
##############################

# clean config cache, e.g. after upgrading
%{__rm} -rf %{cachedir}/config/*.php

##############################
%clean
##############################

%{__rm} -rf %{buildroot}

##############################
%files
##############################
# main dirs
%doc etc/schema contrib doc/README.RHEL doc/AUTHORS doc/CHANGELOG-1.6 doc/CHANGELOG-1.x doc/LICENSE
%defattr(-,root,root)
%{_datadir}/icinga-web/app
%{_datadir}/icinga-web/doc
%{_datadir}/icinga-web/etc
%{_datadir}/icinga-web/lib
%{_datadir}/icinga-web/pub
# configs
%defattr(-,root,root)
%config(noreplace) %attr(-,root,root) %{apacheconfdir}/icinga-web.conf
%dir %{_sysconfdir}/icinga-web
%dir %{_sysconfdir}/icinga-web/conf.d
%config(noreplace) %attr(644,-,-) %{_sysconfdir}/icinga-web/conf.d/*
# logs+cache
%attr(2775,%{apacheuser},%{apachegroup}) %dir %{logdir}
%attr(-,%{apacheuser},%{apachegroup}) %{cachedir}
%attr(-,%{apacheuser},%{apachegroup}) %{cachedir}/config
# binaries
%defattr(-,root,root)
%{_bindir}/%{name}-clearcache

##############################
%changelog
##############################
* Wed Feb 29 2012 Michael Friedrich <michael.friedrich@univie.ac.at> - 1.6.2-2
- move etc/schema sql scripts to docs (thx Michael Gruener) #2381
- install etc/conf.d to {_sysconfdir}/icinga-web/conf.d saving main dir for other configs #2382
- install clearcache.sh as {_bindir}/icinga-web-clearcache #2115
- remove rest of bin/, won't be needed on package install #2116
- add contrib/ and partly doc/ to docs section #2384

* Mon Feb 20 2012 Michael Friedrich <michael.friedrich@univie.ac.at> - 1.6.2-1
- bump to 1.6.2
- clean config cache in %post (important for upgrades) #2217

* Mon Dec 12 2011 Michael Friedrich <michael.friedrich@univie.ac.at> - 1.6.1-1
- bump to 1.6.1
- fix forgotten sla.xml inclusion

* Sat Oct 22 2011 Michael Friedrich <michael.friedrich@univie.ac.at> - 1.6.0-1
- bump to 1.6.0
- add --with-cache-dir and use %{_localstatedir}/cache/icinga-web

* Thu Sep 15 2011 Michael Friedrich <michael.friedrich@univie.ac.at> - 1.5.2-1
- drop icinga-api dependency
- drop BuildRequires - not needed at this stage
- add --with-api-cmd-file, using same location as icinga rpm %{_localstatedir}/icinga/rw/icinga.cmd
- change new config location from default $prefix/etc/conf.d to %{_sysconfdir}/icinga-web
- mark all config xmls as config noreplace
- set %{_localstatedir}/log/icinga-web and use it instead of $prefix/logs
- set apache user/group to write logdir
- reorder files to be included in the package

* Thu May 5 2011 Michael Friedrich - 1.4.0-1
- update for upcoming release

* Mon Jan 10 2011 Michael Friedrich - 1.3.0-1
- update for upcoming release

* Tue Aug 31 2010 Christoph Maser <cmaser@gmx.de> - 1.0.3-2
- add icinga-api as build dependency, --with-icinga-api wil be ignored otherwise
- change icinga-api path to value used in icinga-api-rpm
- set defattr
- set ownership to apache for log-dirs

* Tue Aug 17 2010 Michael Friedrich <michael.friedrich@univie.ac.at> - 1.0.3-1
- updated for 1.0.3, removed fix-priv fix-libs as this is now in make install

* Tue Jun 29 2010 Michael Friedrich <michael.friedrich@univie.ac.at> - 1.0.1-1
- updated for 1.0.1

* Fri Apr 16 2010 Michael Friedrich <michael.friedrich@univie.ac.at> - 0.9.1-1
- initial creation


