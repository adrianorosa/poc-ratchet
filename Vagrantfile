# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "hashicorp/precise64"
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 2828, host: 8888
  config.vm.provision :shell, :path => "provisionamento/bootstrap.sh" 
  config.vm.synced_folder ".", "/var/www", :owner => "www-data", :group => "www-data"
  config.vm.provider "virtualbox" do |vb|
    vb.memory = 768
  end
end
