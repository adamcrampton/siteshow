# siteshow
Automate image snapshots of a managed list of websites for full screen, rotated display in browser.

Note: This project is currently a work in progress.

## The Idea
The usage of this app is pretty much as follows:
* Using an admin front end, add a list of websites (name and URL), along with the options to set order and enable/disable.
* A cron job collates this list (using a predetermined limit), and saves an image snapshot of each URL.
* Hitting the index page of the site displays a full screen version of each site image, rotating through the list based on predefined duration and ordering options.

## Database
**Users**
* name
* email
* permission fk

**User permissons**
* name

**Website list**
* name
* url
* status (disabled or enabled)
* list order
* duration (global default or seconds)
* image path
* created
* last updated

**Global configuration options**
* delay
* item display limit
* item fetch limit
* default save path
* overwrite files y/n

**Logs (cron job results)**

## Front End
An AJAX request will fetch website data:
* where status is enabled
* ordered by list order
* limited by the global limit

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
