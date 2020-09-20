Config
----------------
### Config
git config --global --edit

git config --global core.autocrlf true (for win)
git config --global core.autocrlf input (for linux)

git config --global alias. <alias-name> <git-command>
git config --global alias.adog "log --all --decorate --oneline --graph"
git config --global alias.c checkout
git config --global alias.unstage 'reset HEAD --'
git config --global alias.tidy "rebase -i @{upstream}.."

git config --global user.name "Sam Smith"
git config --global user.email sam@example.com

~/.gitconfig
[alias]
lg1 = log --graph --abbrev-commit --decorate --format=format:'%C(bold blue)%h%C(reset) - %C(bold green)(%ar)%C(reset) %C(white)%s%C(reset) %C(dim white)- %an%C(reset)%C(bold yellow)%d%C(reset)' --all
lg2 = log --graph --abbrev-commit --decorate --format=format:'%C(bold blue)%h%C(reset) - %C(bold cyan)%aD%C(reset) %C(bold green)(%ar)%C(reset)%C(bold yellow)%d%C(reset)%n''          %C(white)%s%C(reset) %C(dim white)- %an%C(reset)' --all
lg = !"git lg1"

hist = log --pretty=format:'%h %ad | %s%d [%an]' --graph --date=short
type = cat-file -t
dump = cat-file -p

c = checkout
b = branch
ci = commit
cm = commit -m
s = status

subtree_add = "!f() { git subtree add --prefix $2 $1 master --squash; }; f"
subtree_up = "!f() { git subtree pull --prefix $2 $1 master --squash; }; f"

# git subtree_add <repository uri> <destination folder>
# git subtree_up https://bitbucket.org/vim-plugins-mirror/vim-surround.git .vim/bundle/tpope-vim-surround

[branch]
master.mergeoptions = --no-ff
autosetuprebase always    # (for auto pull rebase )

[color]
ui=true
status=auto
branch=auto   # (color.branch=auto)
branch.upstream=cyan

[core]
autocrlf true (for win)
autocrlf input (for linux)
editor=vim
excludesfile='<file>'

[diff]
wordRegex=.

[help]
format=html

[merge]
tool=vimdiff
ff = false|only

[pull]
rebase = preserve
rebase = true (rebase automatique)

[push]
default = simple|upstream
  
[remote] #origin
url = https://git@github.com:mary/example-repo.git
fetch = +refs/heads/master:refs/remotes/origin/master
(or fetch = +refs/heads/*:refs/remotes/origin/*)
push = refs/heads/master:refs/heads/qa-master

[rebase]
stat = <bool> (visuel des chagements)
missingCommitsCheck = <warn|error|ignore> (comportement autour des commits manquants)

[status]
showUntrackedFiles=all

[tags]
sort

ENV
----
GIT_MERGE_AUTOEDIT=no

Others
----
- exclude files
.gitignore
.git/info/exclude
(config) core.excludesfile '<file>'

- paths
Branches: .git/refs/heads
Exclude : .git/info/exclude
Stash   : .git/refs/stash

Workflow
==========
* Centralized (like SVN)
** master trunk with local devs
* Feature branch
** master trunk
** multiple feature branches and pull-requests

* Gitflow
** master (v3)
** - support/2.7
** - support/2.8
** - hotfix (merge to master and develop)
** develop
** - feature
** - release (merge to master and develop)

* Forking (open source, often)
** masters trunks multiples for each devs
** ask with pull-request if the official accept the features

GitFlow commands
-------------
* Create feature
  git checkout -b myfeature develop
  
* Intégrate feature
  git checkout develop
  git merge --no-ff myfeature
  git branch -d myfeature
  git push origin develop
  
* Create release
  git checkout -b release-1.2 develop
  ./bump-version.sh 1.2
  git commit -a -m "Bumped version number to 1.2"
  
* Finish release
  git checkout master
  git merge --no-ff release-1.2
  git tag -a 1.2  (-s ou -u <key> for sign) 
  git checkout develop
  git merge --no-ff release-1.2
  git branch -d release-1.2
  
* Create hotfix
  git checkout -b hotfix-1.2.1 master
  ./bump-version.sh 1.2.1
  git commit -a -m "Bumped version number to 1.2.1"
  git commit -m "Fixed severe production problem"
  
* Finish hotfix
  git checkout master
  git merge --no-ff hotfix-1.2.1
  git tag -a 1.2.1
  git checkout develop
  git merge --no-ff hotfix-1.2.1
  git branch -d hotfix-1.2.1
  
Github flow
-----------
* Add feature
  git clone ssh://user@host/path/to/repo.git
  git checkout -b feature/XYZ origin/master

* Continue feature
  git add <files>
  git commit -m "feature(menu) : add items"
  git pull origin master
  git push origin feature/XYZ

Completion
----
https://github.com/git/git/tree/master/contrib/completion

#in "~/.bashrc"
. ~/git-completion.bash
. ~/git-prompt.sh
export GIT_PS1_SHOWDIRTYSTATE=1
export GIT_PS1_SHOWSTASHSTATE=1
export GIT_PS1_SHOWUNTRACKEDFILES=1
export GIT_PS1_SHOWUPSTREAM=verbose
export GIT_PS1_DESCRIBE_STYLE=branch
export PS1='${debian_chroot:+($debian_chroot)}\u@\h:\w $(__git_ps1 "(%s)")\$ '

ou
GIT_PS1_SHOWCOLORHINTS=1
```
export PROMPT_COMMAND='__git_ps1 "\u@\h:\w" " \\\$ "'
export PROMPT_COMMAND='__git_ps1 "\e[0;36m\u\e[m@\h:\e[0;36m\w\e[m" "\$ "'
```

References
----------
[atlassian.com](atlassian.com)
[githowto](https://githowto.com/)
[Tuto](https://www.atlassian.com/fr/git/tutorials)
[30 options](https://delicious-insights.com/fr/articles/30-options-git-qui-gagnent-a-etre-connues/)
[Gitflow - Nvie](https://nvie.com/posts/a-successful-git-branching-model/)
[Beginner](https://www.atlassian.com/git/tutorials/svn-to-git-prepping-your-team-migration)
[Cheat sheets](https://www.atlassian.com/git/tutorials/atlassian-git-cheatsheet)
[git-request-pull] (https://git-scm.com/docs/git-request-pull)


