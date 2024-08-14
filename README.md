# Server Toasts v0.0.1-dev

Server Toasts is a proof of concept module that uses Javascript server-sent events to send "Toast" messages to site users.
<strong>THIS MODULE SHOULD NOT BE USED IN A PRODUCTION ENVIRONMENT. I AM NOT RESPONSIBLE FOR SYSTEM DAMAGE OR DATA LOSS
FROM USING THIS MODULE.</strong> 

These same concepts could be applied to any number of use cases where you need to push 
a message to the user. For example, in a weather application, you could push severe weather alerts to your users 
informing them of those alerts.

## Requirements

This module was developed under Drupal 10.3.2. It should, however still be compatible with Drupal 11.x as well. There
are no other module dependencies for this module to function.

## Installation

Copy the server_toasts folder to <code>[web-root]/modules/custom</code>. Once in place, you can either use Drush to
install the module by issuing the command <code>drush en server_toasts</code> or by browsing to
the site's module page and enabling it from there.

## Uninstalling The Module

Before uninstalling the module, you <strong>MUST DELETE ALL</strong> Toast entities from the content administration
section of your site. Once all Toast entities have been deleted, you can uninstall the module with Drush by issuing the
command <code>drush pm-uninstall server_toasts</code> or by browsing to the site's module page and uninstalling it
from there. This will remove all configurations associated with the module from your database.

## How It Works

The toast messages start by placing the block "Toasts block" in a region on your page (note: this block should only be
placed once). The block has the attached javascript file that uses the EventSource object. This object streams content
from a URL; in this case '/toasts'.

That URL is responsible for querying the database to get instances of the custom entity "Toasts" that are currently
published. It then formats those entities and streams them back to the browser.

In the javascript, an event listener is added to the EventSource instance watching for the event 'toast'. When it receives
this event, it creates new DOM elements and pushes them to a container which displays the toast to the user. Once displayed,
a timer is created which removes the toast after 30 seconds.

## Enhancements

* This module could be enhanced by adding a more robust process for determining how a toast is deemed "seen" by the user.
In its current form, when the toast event is received, the event ID is added to an array that is kept in the browser's
localStorage.
* A close button could be added to the toasts to allow for manual closing of the toast.
* By adding an entity reference field to the Toast entity bundles, you could assign each toast message to a specific user
  so only specific users see specific message.
