Vagrant.configure("2") do |config|
	config.vm.box = "debian/stretch64"

	config.vm.network "forwarded_port", guest: 80, host: 8080

	config.vm.provision "shell", path: "Vagrant/bootstrap.sh"

	# NFS merda! (anche rsync merda, ma almeno è merda che funziona)
	config.vm.synced_folder ".", "/vagrant", type: "rsync"

	# Vagrant merda!
	# https://stackoverflow.com/a/42397127
	config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
end
