<?php

/*GLOB */ //rUBY?

//Dir.glob('lib/capistrano/tasks/*.cap').each { |r| import r }
//Dir.glob('lib/capistrano/**/*.rb').each { |r| import r }




/* 
 * Gettext
 */
session_start();
  if (isset($_GET["locale"])) {
    $locale = $_GET["locale"];
  }
  else if (isset($_SESSION["locale"])) {
    $locale  = $_SESSION["locale"];
  }
  else {
    $locale = "en_UK";
  }
  putenv("LANG=" . $locale); 
  setlocale(LC_ALL, $locale);
  $domain = "example";
  bindtextdomain($domain, "Locale"); 
  bind_textdomain_codeset($domain, 'UTF-8');
  textdomain($domain);
  $domain2 = "example2";
  bindtextdomain($domain2, "Locale"); 
  bind_textdomain_codeset($domain2, 'UTF-8');
  $user = "Curious gettext tester";
  // _() is an alias of gettext()
  echo _("Let’s make the web multilingual.");
  echo _("We connect developers and translators around the globe 
on Lingohub for a fantastic localization experience.");
  echo sprintf(_('Welcome back, %1$s! Your last visit was on %2$s', $user, date('l')));
  // dgettext() is similar to _(), but it also accepts a domain name if a string from
  // a domain other the one set by textdomain() needs to be displayed
  echo dgettext("example2", "");
  // ngettext() is used when the plural form of the message is dependent on the count
  echo ngettext("%d page read.", "%d pages read.", 1); //outputs a form used for singular
  echo ngettext("%d page read.", "%d pages read.", 15); //outputs a form used when the count is 15

  
  /*
   * 
    bind_​textdomain_​codeset
    bindtextdomain
    dcgettext
    dcngettext
    dgettext
    dngettext
    gettext
    ngettext
    textdomain

   */