# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "generic/ubuntu2004"
  config.vm.box_version = "4.3.12"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"
  config.vm.synced_folder "./", "/vagrant", type: "nfs", nfs_udp: false

  config.vm.provider :libvirt do |libvirt|
    # Use QEMU system instead of session connection
    # libvirt.qemu_use_session = false
  end

  config.vm.provision "shell", inline: <<-SHELL
    export DEBIAN_FRONTEND=noninteractive

    debconf-set-selections <<< 'mysql-server mysql-server/root_password password blis123'
    debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password blis123'

    apt-get update
    apt-get install -y software-properties-common
    add-apt-repository ppa:ondrej/php
    apt-get update
    apt-get install -y \
        acl \
        apache2 \
        cron \
        curl \
        git \
        libharfbuzz0b \
        libpango-1.0-0 \
        libpangoft2-1.0-0 \
        mysql-client \
        mysql-server \
        pandoc \
        python3-pip \
        python3-venv \
        sudo \
        unzip \
        weasyprint \
        zip \
        php5.6 \
        php5.6-bcmath \
        php5.6-curl \
        php5.6-gd \
        php5.6-mysql \
        php5.6-zip \
        php5.6-mbstring \
        php5.6-xml

    echo "column-statistics = 0" | tee -a /etc/mysql/conf.d/mysqldump.cnf

    cp /vagrant/docker/config/blis-dev.conf /etc/apache2/sites-available/blis.conf
    rm /etc/apache2/sites-enabled/000-default.conf
    ln -s /etc/apache2/sites-available/blis.conf /etc/apache2/sites-enabled/blis.conf
    a2enmod rewrite
    systemctl restart apache2.service
    echo ". /var/www/apache2_blis.env" >> /etc/apache2/envvars

    cp /etc/php/5.6/apache2/php.ini /etc/php/5.6/apache2/php.ini.original
    cp /vagrant/docker/config/php.ini /etc/php/5.6/apache2/php.ini
    cp /vagrant/docker/bin/start-blis.sh /usr/bin/start-blis

    touch /var/www/apache2_blis.env && chown vagrant /var/www/apache2_blis.env
  SHELL
end
