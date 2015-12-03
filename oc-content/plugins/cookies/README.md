European Cookie law
===================



It makes your website compatible with the European Cookie law, it's based in the JQuery plugin [CookieCuttr](http://cookiecuttr.com/).



### IMPORTANT - WARNING

The European Cookie law is "open" to interpretation on what it's considered "consent" or not. This plugin (if configured) will create Google Analytics cookies until they are declined (to get better stats), if you feel that's wrong and Google Analytics don't have to be created until the cookies are accepted change the following code in the index.php file.

From

```php
            if (jQuery.cookie('cc_cookie_decline') == "cc_cookie_decline") {
            } else {
```

To

```php
            if (jQuery.cookie('cc_cookie_accept') == "cc_cookie_accept") {
            // remove the } else { too
```

### Features
* Easy to use
* Messages could be modified
* Easy integration with Google Analytics (if you use GA with this plugin, disable any other plugin you have of GA)


### Future development and ideas
I plan to add some more configuration options based on the feedback (if you give some)

### IMPORTANT NOTE 2
As far as I know, the whole European Cookie law is about third party cookies (facebook, google, twitter,...) anything you include in your site to track the visit or depends on a external service. Osclass itself only uses cookies to store the required session/login data and you don't have to warn the user about them. This plugin **DO NOT STOP** the use of other cookies such as facebook or twitter, it just warn the user about them and consider that if you keep browsing the site you consent them (what most sites do). It's very hard to adapt it to every country's own law, and every website out there.

### IMPORTANT NOTE 3
This plugin will only works with Osclass 3.2 and superior
