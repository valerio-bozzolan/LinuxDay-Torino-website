Vagrant.configure("2") do |config|
	config.vm.box = "debian/stretch64"

	# 80 internal: apache exposed as 8080
	config.vm.network "forwarded_port", guest: 80,   host: 8080

	# 8008 internal: nginx exposed as 8008
	config.vm.network "forwarded_port", guest: 8008, host: 8008

	config.vm.provision "shell", path: "Vagrant/bootstrap.sh"

	# https://wiki.debian.org/Vagrant#Errors_on_NFS_mount
	config.vm.synced_folder ".", "/vagrant", nfs_version: "3"

	# Vagrant merda!
	# https://stackoverflow.com/a/42397127
	config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
end
