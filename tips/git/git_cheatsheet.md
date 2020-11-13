Commands
--------
### Add
git add -(i)nteractive
git add -(p)atch (answer y/n for each hunk)
git add -(e)dit
git add -A / -u (tout le dépot)
git add --(no-)all[^2] (se base uniquement sur working dir)
git add --(no-)ignore-removal

### Apply

### Bisect
git bisect start
git bisect bad
git bisect good v1.9.0
git bisect visualize

### Blame
(infos sur un fichier)
git blame README.MD -w (whitespace) -M (modifs) -C (other modifs)

### Branch
git branch <branch_name> <commit_base>
git branch v1.14-0.1 <commit_de_base>

git branch -a (list remotes)
git branch -d future-plans (delete safe)
git branch -D future-plans (force deleting!)
git branch -r (remote)
git branch -m <branch> (rename)
git branch --list pr-* (regex)
git branch --track origin/feat5 (suivre remote branch)
git branch --set-upstream-to=origin/topic topic

- créer une nouvelle branche
git checkout -b feature-branch master 

- remotes
git remote add new-remote-repo https://bitbucket.com/user/repo.git
git push <new-remote-repo> experiment~
git push origin --delete experiment (delete remote)
git push origin :experiment (delete remote)

- create new remote branch
(if git push --set-upstream origin test2 doesn't work)
git push origin HEAD:test2

- move branch head place
git branch -f <branch-name> <new-tip-commit>
 or with
git update-ref 

- to see branch config
git branch -vv
git config --list OR --get-regex 'branch'

- parent de la branche courante
git show --summary $(git merge-base test2 master)

### Checkout
(files, commits, and branches.)
git checkout -- <filename> (undo changes)
git checkout HEAD -- string_operations.c
git checkout -b <new-branch> <existing-branch> -(t)rack <origin/branch> (use existing-branch as base)
git checkout <remotebranch>
git checkout v1.4

- after fetch
git diff --stat -p remotes/origin/master <file>
git checkout master -- <file>

### Cherry-pick
git cherry-pick <commitSHA> --edit (message) --no-commit (copy only files) --signoff (signature)

- récupère un commit précédent
git cherry-pick -
git cherry-pick @{-1}

### Clean
git clean -n -d   # list all files/directories that would be removed
git clean -f
git clean -(i)nteractif
git clean -x (fichiers ignorés)

### Clone
- for big project
git clone --depth [depth] [remote-url] 
git clone [remote url] --branch [branch_name] --single-branch [folder]

### Commit
git commit -a (auto stage) -m <msg>
git commit --amend -m <msg>

- update last (like git reset --soft HEAD^)
git commit --amend (modify last commit, add files, edit msg)
git commit --amend --no-edit (sans modif du msg)

- git < 1.7.9
git commit --amend -C HEAD

### Describe
git describe --tags
git describe --abbrev=0 --tags
  
### Diff
git diff HEAD (between workingdir and last commit)
git diff --base <filename>  --color-words
git diff <sourcebranch> <targetbranch>
git diff --cached ./path/to/file (like --staged)
git diff --staged index.html
git diff -w (--ignore-all-space)
git diff --word-diff (non plus par ligne mais par mot)
git diff --word-diff=color (--color-words) (--color-words=<regex>) (exprime ce qu'est un mot)
git diff --word-diff-regex=<regex> (--word-diff-regex=.)

- tips
git diff --stat --cached origin/master (about to commit)

### Fetch
git fetch --all origin
git fetch <remote> <branch> --dry-run

- ex
git fetch coworkers feature_branch
git checkout coworkers/feature_branch
git checkout -b local_feature_branch

### Filter-branch
- split subfolder to a new repo
git filter-branch --prune-empty --subdirectory-filter <folderName> master

- supprimer un fichier de toutes les branches (infos sensibles)
git filter-branch --index-filter 'git rm --cached <file>' HEAD

- git filter-branch -f --tree-filter 'git rm -rf --ignore-unmatch ./**/*.item*' --prune-empty -- --all
- git filter-branch -f --tree-filter 'git rm -rf --ignore-unmatch ./**/diehard.json' --prune-empty -- --all
- git grep -l 'original_text' | xargs sed -i 's/original_text/new_text/g'

### Format-patch
- apply a patch from unrelated repository
git format-patch  --git-dir=<pathToOtherLocalRepo>/.git -k -1 --stdout <otherLocalCommitSHA> | git am -3 -k

### Gc
git gc (garbage collector)	

### Log
git log -- foo.py bar.py
git log --all --decorate --oneline --graph  (--abbrev-commit)
git log --stat (number modifs) 
git log -p (inside files) 
git log --after="2014-7-1" --before="2014-7-4"
git log --author="John\|Mary" 
git log -S"Hello, World!" (inside file) -i (case insensitive)
git log -S'text inside' --pickaxe-regex -- <path/file>
git log -G"<regex>" -i
git log --grep="JRA-224:"
git log master..feature --no-merges
git log <since>..<until>
git log --oneline master..feature
git log -n 10 (or -10) (only 10 last)
git log -- . ':!dir' (tout sauf)
git log --exclude='*/*' --branches
git shortlog

- After Fetch
git log --oneline master..origin/master

- ex
git log -S"CSS3D and WebGL renderers." --pretty=format:'%h %an %ad %s'

- only for one branch
git log set --first-parent --oneline --not master
git rev-list --oneline <branch> --not master

git log master..
git log master..<branch>
git cherry -v master

### Merge
git merge <merging-branch1> <merging-branch2> (in current)
git merge master someone-feature feature3

git merge --abort
git merge - (pour fusionner la branche qu'on vient de quitter)
- check base
git merge-base feat01 master C D 

- after fetch
git checkout feature
git merge origin/feature

- strategy
git merge -s recursive branch1 branch2 (default with one branch)
git merge -s resolve branch1 branch2 (3 heads)
git merge -s octopus branch1 branch2 branch3 branchN
git merge -s ours branch1 branch2 branchN
git merge -s subtree branchA branchB (like recursive)

- types
explicit: create new commit
implicit: rebase or ff
squash: when interactive rebase

### Patch
git format-patch -1 (create patch)
git apply 0001-Added-my_strcat-function.patch

### Pull
. git fetch origin
. git merge origin/next

git pull --rebase=preserve (recommandé!)
git pull --rebase --preserve (--preserve-merges)

git pull --rebase origin master
git pull --all
git pull --verbose

### Pull-request

### Push
git push -u (--set-upstream) origin new-feature 
git push <remote> --tags --force --all

- delete remote branch
git push origin :some-feature (delete some-feature in origin)
git push origin --delete some-feature

- force
git push origin +HEAD (force-push the new HEAD commit)

- submodules
git push --recurse-submodules=check|on-demand

- tags
git push origin v1.4
git push --tags origin v1.4 v1.5

- tips: Undo a git push:
git push -f origin <last_good_commit>:<branch_name> (ex: cc4b63bebb6:alpha-0.3.0)

### Rebase (never on public) !!!
git rebase master
git rebase HEAD~3
git rebase --autosquash
git rebase -- d (commit supprimé) -- p (commit laissé tel quel)
    (ne pas oublier "git merge" ensuite)
git rebase --root
git rebase -i @{-1}
git rebase - (la branche précédente)
git rebase --(p)reserve-merges

- sample
git rebase master <moving_branch>
..git checkout <branch>
..git rebase master
          A---B---C <branch>
        /
    D---E---F---G master
devient:
	                     A'--B'--C' topic
                            /
    D---E---F---G master

- interactif
git rebase -i master 
  pick, (r)eword, (f)ixup, (s)quash...
git rebase -i HEAD~2 (rebase last 2)

git rebase -i --exec "cmd1 && cmd2 && ..."
  
- onto
git rebase --onto <newbase> <oldbase>
git rebase --onto <newbase> <oldbase> <moving-branch>
git rebase featureA featureB --onto master
 o---o---o---o---o master
           o---o---o---o---o featureA
                  o---o---o featureB

devient:
					o---o---o featureB
    o---o---o---o---o master
         o---o---o---o---o featureA

- erase a commit
git rebase --onto topicA~5 topicA~2 topicA
git push origin topicA -f

E---F---G---H---I---J  topicA
devient:
E---H'---I'---J'  topicA

1. 138fd8c docker
2. e87dd63 clean
3. 802c39b Update bubble_sort.php
4. 3f7fc31 Create bubble_sort.php
5. 97ea674 Update insertion_sort.php

devient:
1. 75c0c5d docker
5. 97ea674 Update insertion_sort.php

- erase 2eme exemple
1. 4e137a1 - (5 seconds ago) create past.rb - cyril (HEAD -> master, origin/master)
2.  2c9c44b - (66 seconds ago) remove edit.rb - cyril
3.  a4815ce - (15 minutes ago) add name param - cyril
4.  c36174a - (57 minutes ago) create edit.rb amended - tutoname
5.  3e86b09 - (72 minutes ago) create edit.rb - tutoname
6. 6f4becc - (3 days ago) test - cyril

> git rebase --onto 6f4becc 2c9c44b master(optional when one branch)

1. 00c169f - (5 minutes ago) create past.rb - cyril (HEAD -> master)
6. 6f4becc - (3 days ago) test - cyril

(eventuellement git cherry-pick)
git push origin +HEAD (force)

1. 00c169f - (10 minutes ago) create past.rb - cyril (HEAD -> master, origin/master)
6. 6f4becc - (3 days ago) test - cyril

- tips
Rebase fréquent d'une branche parallèle en dev
git rebase --continue --abort

### Ref / reflog
git reflog --relative-date
git checkout HEAD@{1}
- HEAD – The currently checked-out commit/branch.
- FETCH_HEAD – The most recently fetched branch from a remote repo.
- ORIG_HEAD – A backup reference to HEAD before drastic changes to it.
- MERGE_HEAD – The commit(s) that you’re merging into the current branch with git merge.
- CHERRY_PICK_HEAD – The commit that you’re cherry-picking.

### Remote
- ssh://user@host/path/to/repo.git
git remote add origin <server_url>
git remote -v
git remote rm <name>
git remote rename <old-name> <new-name>
git remote show <upstream>
git remote add coworkers_repo git@bitbucket.org:coworker/coworkers_repo.git
git remote add -f <local_name> https://bitbucket.org/vim-plugins-mirror/vim-surround.git
git remote add durdn-vim-surround ssh://git@bitbucket.org/durdn/vim-surround.git

git remote show origin (show branches)

- only one branch
git remote add -t <remoteBranchName> -f origin <remoteRepoUrlPath>

### Reset
- Reset: reset the 3 trees to match the state of a specified commit
git reset --keep --merge
git reset --hard origin/<branchname> (get the last remote commit)
git reset HEAD~2 --soft (commits history) --mixed (default, commits and staging) --hard (all match now the commit)
git reset HEAD~2 foo.py
git reset HEAD^ # remove commit locally
git reset -p HEAD^ index.html (patch only one hunk, inverse de add -p)
git reset --merge ORIG_HEAD

- The three trees:
Working dir, staged snapshot (git add .), commit history

### Revert / rm
- Revert: create the opposite of a single commit (safe public)
git revert <commit>

- Rm
git rm -f (--force) -n (--dry-run) -r (recursive)
git rm --cached (only staging) -- <file1><file2>
git rm Documentation/\*.txt

### Show
git show --pretty[=<format>] oneline, short, medium, full, fuller, email, raw, et format:<string>
git show --(-no)-abbrev-commit --oneline
git show --show-signature
git show --(-no)-notes=<ref>
git show --(-no)-expand-tabs=<n>
git show feature-01
git show refs/heads/feature-01
git show --pretty="" --name-only bd61ad98
git show REVISION:path/to/file
git show v2.0.0 6ef002d
git show commitA...commitD
git show :0:index.html (voir le snapshot du stage)

- branches 
git show-branch --(a)ll <branch>
git show-branch --(r)emotes

- ex
git show $(git rev-parse master)

### Status
git status -(u)ntracked-files

### Stash
git stash apply
git stash pop (apply and remove) --index (reconstruit l'index)
git stash pop stash@{2}
git stash show -p
git stash branch (creer une nouvelle branch)
git stash -u --incl(u)de-untracked
git stash -a (-all) (include ignored files) 
git stash -k (stash what-s not in index)
git stash list
git stash save "message inclus"
git stash drop stash@{1}
git stash clear
git stash save --keep-index  (stash only unstaged files)

- Inspect 
git log --oneline --graph stash@{0}

- env
GIT_PS1_SHOWSTASHSTATE=1

### Status
git status -(u)ntracked-files

### Submodule
git submodule add https://bitbucket.org/jaredw/SUBDIR
.. .gitmodules
.. SUBDIR
git submodule init <module-name>
git submodule update

git clone --recursive (--recurse-submodules)

- add local repository
git submodule add --force --branch dev git@github.com:<remote_path>/<remote_path> <../local_path_dir>

-> prefer "Subtree" instead

### Subtree
git subtree add --prefix <dir/path> <origin2_stream> master --squash
git subtree pull --prefix <dir/path> <origin2_stream> master --squash

- Contribute
git subtree push --prefix=<dir/path> <origin3_stream> master

- Without subtree command
git remote add -f tpope-vim-surround https://bitbucket.org/vim-plugins-mirror/vim-surround.git
git merge -s ours --no-commit tpope-vim-surround/master
git read-tree --prefix=.vim/bundle/tpope-vim-surround/ -u tpope-vim-surround/master
git commit -m "adding tpope-vim-surround" <subtree>
git pull -s subtree tpope-vim-surround master

- Quick way
git subtree add --prefix .vim/bundle/tpope-vim-surround 
	https://bitbucket.org/vim-plugins-mirror/vim-surround.git master --squash (skip the entire project)
git subtree pull --prefix .vim/bundle/tpope-vim-surround 
	https://bitbucket.org/vim-plugins-mirror/vim-surround.git master --squash

### Tags
git tag 1.0.0 <commitID> (1.0-lw léger)
git tag -a v1.4 (annoté avec auteur, etc)
git tag -a v1.4 -m "my version 1.4"
git tag -l *-rc* (like)
git tag -a -f v1.4 15027957951 (force modif)
git tag -d v1 (delete)

- to remote
git push tags/<nom_du_tag> like a branch
git push origin <tagname>
git push origin --tags (all tags)

### Good practice
- si branch de dev temporaire (à enlever)
on rebase pendant que master évolue sinon --f(ast)f(orward)
ou alors merge --fast-forward pour lisser l'historique

- si branch utile (fix ou feature) a garder
si master n'as pas bougé, utiliser --no-ff pour forcer la branche (true merge)

- rebase souvent le temps du dev pour eviter conflits finaux
- si push refusé, on rebase proprement sur la nouvelle branche distante

- ex
git commit --amend
git merge, avec ou sans --no-ff
git rebase, et notamment git rebase -i et git rebase -p
git cherry-pick (qui est fonctionnellement inséparable de rebase)

### Navigate
HEAD^^ (go to 2dn before HEAD)
HEAD^3^2 (go to 3dn before HEAD passing 2nd parent branch)
HEAD~3 (go back by 3 before HEAD)

Plumbing
------------
### Cat-file
git cat-file -p <commit> (see infos on commit)

### Checkout-index
git checkout-index (Copy files from the index to the working tree)

### Commit-tree

### Diff-index

### For-each-ref

### Hash-object

### Ls-files
git ls-files -s (index de staging)

### Ls-tree

### Merge-base

### Read-tree

### Rev-list

### Rev-parse
git rev-parse master (resolve hash)

### Show-ref

### Symbolic-ref
git symbolic-ref HEAD

### Update-index
- ignore changes in tracked file
git update-index --assume-unchanged <pathToLocalFile>
git update-index --skip-worktree <file-list>

### Update-ref
- move branch head place
git update-ref refs/heads/<branch> <commit>    -m "reset: Reset <branch> to <new commit>"
git update-ref <ref> <commit>    -m "reset: Reset <branch> to <new commit>"
