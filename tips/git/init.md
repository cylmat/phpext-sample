#########
# Init repo
#  (on remote server)
#########
$ cd repos
$ mkdir myrepo && cd myrepo
$ git init --shared=true
$ git add .
$ git commit -m "my first commit"
$ cd ..
$ git clone --bare myrepo myrepo.git

ou
mkdir myrepo.git && cd myrepo.git
git init --shared=true --bare

#########
# Upload a repo
#  (from local)
#########
From host:
$ mv myrepo.git ~/git-server/repos
From remote:
$ scp -r myrepo.git user@host:~/git-server/repos

#########
# Clone a repo
#  (from local)
#########
$ git clone ssh://git@<ip-docker-server>:2222/git-server/repos/myrepo.git
$ git clone ssh://git@192.168.99.100:2222/git-server/repos/myrepo.git

#########
# Clone a repo
#  (from inside phpfpm container)
#########
