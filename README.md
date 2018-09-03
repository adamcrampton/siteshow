# siteshow
Automate image snapshots of a managed list of websites for full screen, rotated display in browser.

Note: This project is currently a work in progress.

## The Idea
The usage of this app is pretty much as follows:
* Using an admin front end, add a list of websites (name and URL), along with the options to set order and enable/disable.
* A cron job collates this list (using a predetermined limit), and saves an image snapshot of each URL.
* Hitting the index page of the site displays a full screen version of each site image, rotating through the list based on predefined duration and ordering options.

## Config
The following config options are available:
* Display delay
* Fetch limit
* Page list limit
* Overwrite files y/n
* Fetch window width
* Fetch window height
* Dismiss dialogues y/n
* Wait until network idle y/n
* Fetch delay
* Image save path

## Database
**users**
* name
* email
* password
* user_permissions_fk
* token & timestamps

**user_permissions**
* permssion
* timestamps

**pages**
* name
* url
* status (disabled or enabled)
* duration (global default or seconds)
* image path
* rank
* timestamps

**options**
* option_name
* option_value
* timestamps

**fetch_logs (cron job results)**
* started
* finished
* duration
* output (JSON)
* timestamps

## Front End
An AJAX request will fetch website data:
* where status is enabled
* ordered by list order
* using all option settings

The returned JSON will be interated through, showing a full screen image of each item in the list, cycling to the next based on the delay value set.

## Back End
A cron job will hit the list of sites (bound by global fetch limit), to create a data object that can be inserted to the sites and log tables.

## Admin
An admin frontend is provided to allow:
* CRUD functions for the website list
* Draggable functionality to set ordering
* A search facility to locate previously added websites
* Pagination
* User management (admins)
* Global configuration (admins)
