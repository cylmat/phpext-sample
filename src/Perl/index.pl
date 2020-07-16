#!/usr/bin/perl -w
#curl -L https://cpanmin.us | perl - App::cpanminus

############################################
#######
####### https://perl.developpez.com/tutoriels/livres/programmation-en-perl/
#######
############################################

use strict;
use warnings; #not necessary because perl -w

############ ARGS ##############
print "*** ARGS ***\n";
if($ARGV[0]) {
    print ($ARGV[0]." perling!\n");
} else {
    print ("perling!\n");
}

####### ARRAY ############
print "$/*** ARRAY ***\n";
my @arr = (5, 9, 'ml', 'a'..'e', ('t'));
print $arr[$#arr]."\n"; #  $#arr is the last key

my @op = ['john', 'michel', 'alpha'];


############ LOOPS #######
print "$/*** LOOP ***\n";
while (my ($k, $v) = each @op) { 
   print $k.':'.$v."\n";
}

foreach my $i (keys @op) {
   print $i.':'.$op[$i]."\n";
}

# ($_) is the current index
foreach (keys @op) { 
   print $_.':'.$op[$_]."\n";
}

LINE:
for (;;) {
   print '';
   last LINE if 1;
   next LINE if /^#/;
   print '';
}


############# FORMATS ################
print "$/*** FORMATS ***\n";
# @>>>> right-justified
# @|||| centered
# @####.## numeric field holder
# @* multiline field holder

#ref: https://perldoc.perl.org/perlform.html
select(STDOUT);
$~ = "EMPLOYEE";  # $~ is current format name

my ($name, $age, $salary); #they are defined in the loop

format EMPLOYEE = 
*****************
@<<<<<<<< @<<
$name, $age
@#####.##
$salary
=================
.

my @n = ("Alice", "Raza", "Jenyffer");
my @a  = (20, 30, 40);
my @s = (2000.00, 2500.00, 4000.000);

my $i=0;
for (@n) { 
   $name = $_;
   $age = $a[$i];
   $salary = $s[$i++];

   write; 
}

# deuxieme
my @b = qw/one two three four five azer six seventy octo/;
select(STDOUT);
$^ = "TEST_TOP"; #$FORMAT_TOP_NAME
$~ = "TEST"; #$FORMAT_NAME
# $% is the $FORMAT_PAGE_NUMBER
$= = 15; #is the $FORMAT_LINES_PER_PAGE default is 60
# $- ($FORMAT_LINES_LEFT)


format TEST_TOP =
==================
header     page @<
                $%
==================
.

format TEST =
---+++---
@* @* @* ~~
(shift @b||'', shift @b||'', shift @b||'')
---------
.
write;


############# FILES IO #######################
#
# https://perldoc.perl.org/functions/open.html
print "$/*** FILES IO ***\n";
use Fcntl; #escape errors strict

# <read only (r)
# >write (and truncate) C/W/Trunc (w)
# +<open to update R/W (r+)
# +>truncate first R/W/C/T (w+)
# >>append noread Create/W/App (a)
# +>>append and can read it R/W/A/C (a+)

my $file = "/var/www/source/Parser/perl/test.txt";
my $file2 = "/var/www/source/Parser/perl/test2.txt";

#write
my $str = <<R;
sample tests
R

for (1..2) {
   open DATA, '>>', $file or die $!; #append
   print DATA $str;
   close DATA;
}

#read
open DATA, '<', $file or die $!;  #open DATA, '<'.$file
read DATA, my $test, 1024, 0; #FILEHANDLE, SCALAR, LENGTH, OFFSET
print $test;
while (<DATA>) { #read <FILEHANDLER>
   #print $_;
}
close DATA;

#system
sysopen (DATA, $file, O_RDONLY | O_NONBLOCK); #O_RDWR | O_TRUNC
my @lines = <DATA>;
print STDOUT $lines[0];
close DATA;

#copy
open DATA, '<', $file; #read
seek DATA, 3, 0; #2eme bit in the file
open DATA2, '>', $file2;
while (<DATA>) {
   print DATA2 $_;
}
close DATA;
close DATA2;

#description
# https://perldoc.perl.org/5.32.0//functions/-X.html
my @desc;
if (-e $file) {
   push @desc, 'binary' if (-B _); 
   push @desc, 'executable' if(-x _);
   print "$file is ", join(',', @desc), "\n";
}

#remove
unlink $file;
unlink $file2;

############# DIRECTORIES #######################
foreach (glob("/home/*.c")) {
   #print $_ . "\n";
}

opendir (DIR, '.') or die "Couldn't open directory, $!";
while (my $file = readdir DIR) {
   #print "$file\n";
}
closedir DIR;


############# ERRORS #######################
print "$/*** ERRORS ***\n";
unless(chdir("/etc")) {
   print ("Error: $!\n"); #$! last error
}

warn "Warning: Can't change directory!: $!" unless(chdir("/etc"));

#Carp : warn
#croak: die
#cluck : carp+
#confess : die+

use Carp; #like 
use Carp qw(cluck);
#cluck "Cluck in module!"; #Cluck in module! at source/Parser/perl/log.pl line 17.

############# VARIABLES #######################
#
# https://www.tutorialspoint.com/perl/perl_special_variables.htm
use English;

foreach (5..7) {
   #print $ARG; print $_; print; 
}

#filehandle: $. or $NR
#print $/ . $RS; #newline \n


############### STANDARDS ####################
#opendir(D, $dir) or die "can't opendir $dir: $!";

#print "Starting analysis\n" if $verbose;


########### REGEXP #########################
print "$/*** REGEXP ***$/";
#    Match Regular Expression - m//
#      work like q//
#      m{}, m(), and m>< are all valid
#    Substitute Regular Expression - s///
#    Transliterate Regular Expression - tr///

# operators: (i)nsensible (m)^$ work with newline
#     (o)nce   (s) . is newline    (x) use whitespace allowed
#     (g)lobally  (cg)continue after global fail

my $bar = "This is foo and again foo";

if ($bar =~ /is/) { print "'is' matching\n"; }

print "Time is matching\n" if ($bar =~ m(again));

my $true = ('check' =~ m/foo/);

my ($hours, $minutes, $seconds) = ('11:23:56' =~ m/(\d+):(\d+):(\d+)/);
print $hours.$2.$/;

# first last
my @list = qw/food foosball subeo footnote terfoot canic footbrdige/;

foreach (@list) {
   my $first = $1 if /(foo.*?)/;
   my $last = $1 if /(foo.*)/;
}

#variables
my $string = "The food is in the salad bar";
$string =~ m/foo/;
print "Before: $`\n"; #The
print "Matched: $&\n"; #foo
print "After: $'\n"; #d is the...

#sub
$string = "The cat sat on the mat";
$string =~ s/cat/dog/;
$string =~ s/dog/print "epsilon"/e; #evaluate perl statement
#           (evaluate)The (return) sat on the mat

#translate
#
# https://perldoc.perl.org/perlop.html#Regexp-Quote-Like-Operators
$string = 'The cat sat on the mat';
$string =~ tr/a/o/; #every a by o
$string =~ y/a-z/A-Z/;
print "$string\n";

#MATCHES
# . all except newline (use m)       \10 octal
# \s space, equal to [\t\n\r\f]
# \A begining of string     \ end of string, before newline
# \b word boundary     [\b] backspace
#        /\bcat\B/ # Matches 'catatonic' but not 'polecat'
#        /\Bcat\B/ # Matches 'verification' but not 'the cat on the mat'

$string = "Cats go Catatonic\nWhen given Catnip";
(my $start) = $string =~ /\A(\w+) /; #/\A(\w+) / doesnt return
(my @line) = $string =~ /^\w+ /gm;
print $start." @line".$/;

#GLobal \G is like pos()
$string = "Hello is: 12:31:02 on 4/12/00";

$string =~ /:\s+/g; #KEEP IN MEMORY -AFTER- last match
(my $time) = ($string =~ /\G(\d+:\d+:\d+)/); #Global match comes at \G
$string =~ /.+\s+/g; #keep in memory
(my $date) = ($string =~ m{\G(\d+/\d+/\d+)});

# print "Time: $time, Date: $date$/";

#greedy
# <.*> match <  python>perl  >
#<.*?> match <python>    perl>

#anchor
#Python(?=!)     Matches "Python", if followed by an exclamation point
#Python(?!!)     Matches "Python", if not followed by an exclamation point

#R(?#comment) match R, rest is comment
#R(?i)uby     uby insensitive
#R(?i:uby)

############ MAIL ############
#print "$/*** MAIL $/";
#open(MAIL, "|/usr/sbin/sendmail -t");
#print MAIL $message;
#close(MAIL);