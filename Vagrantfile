# -*- mode: ruby -*-
# vi: set ft=ruby :
Vagrant.require_version ">= 1.8"
Vagrant.configure(2) do |config|

    config.vm.box = "puppetlabs/ubuntu-14.04-64-puppet"
    config.vm.box_version = "1.0.1"

    # Networking.
    config.vm.network "forwarded_port", guest: 80, host: 8081
    config.vm.network "private_network", ip: "192.168.50.5"

    # Provider
    config.vm.provider "virtualbox" do |v|
        v.linked_clone = true
        v.name = "phpcodecassonne"
        v.memory = 1024
        v.cpus = 2
    end

    # Provisioning (Shell Script)
    config.vm.provision "shell", path: "build/vagrant/provision.sh"

end
