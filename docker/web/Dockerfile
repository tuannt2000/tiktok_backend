FROM centos:7

WORKDIR /home/tiktok
EXPOSE 80
ENTRYPOINT ["/usr/sbin/httpd", "-DFOREGROUND"]

# yum install needed packages
RUN yum -y install \
    git \
    wget \
	iproute \
	net-tools \
	bind-utils \
	vim-enhanced \
	epel-release \
	nginx \
	httpd \
	mysql \
	sudo \
	curl \
	unzip \
	&& wget http://rpms.famillecollet.com/enterprise/remi-release-7.rpm \
	&& rpm -Uvh ./remi-release-7.rpm \
    && sed -i '4a priority=1' /etc/yum.repos.d/remi-php74.repo

RUN yum -y install --enablerepo=remi-php74 \
	php \
	php-gd \
	php-mcrypt \
	php-cli \
	php-common \
	php-mbstring \
	php-mysqlnd \
	php-opacache \
	php-pdo \
	php-pear \
	php-pecl-apcu \
	php-pecl-zip \
	php-process \
	php-xml \
	php-intl \
	php-memcached \
	php-xdebug \
	&& yum clean all

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin \
    && php -r "unlink('composer-setup.php');"

# WORKDIR のオーナー・グループの設定
RUN chown apache:apache /home/tiktok

# data領域のコピー
ADD --chown=apache:apache data/ /data/
