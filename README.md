Plugin Name: WP Referrer Modal

Plugin URI:  https://github.com/sterndata/wp-referrer-modal

Description: warn about follow homes from wordpress.org

Tests to see if the access is coming from a link on WordPress.org and, if so, fires a modal dialog showing the text
in the main plugin file.

OMG, big problems:

1.  This was originally developed on a bootstrap-based theme. As a workaround, tthe plugin now brings in bootstrap.
2.  That should be redone so it's all just jquery.

~~3.  Worse yet, it uses the_content to add the modal text. But the twentyseventeen theme pulls in pages so each page on the home page has the modal text added.~~

So -- please do not regard this plugin as "ready for prime time".

To-do:
  * Separate the text from the plugin and store as an option
  * Add option to use other referrers and have text linked to the referrer
  
 
![Screenshot](screenshot.png?raw=true "Title")
