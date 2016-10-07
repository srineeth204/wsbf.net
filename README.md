wsbf.net
========

This repository contains the code for all of WSBF's web presence, which includes the following sites:

- https://wsbf.net
- https://wsbf.net/mobile/ (also http://m.wsbf.net)
- https://wsbf.net/stream/ (formerly http://stream.wsbf.net:8000)
- https://wsbf.net/wizbif/ (formerly http://new.wsbf.net)
- https://dev.wsbf.net

## Installation

The development setup requires `node` and `npm`.

	git clone https://github.com/wsbf/wsbf.net [directory]
	cd [directory]
	npm install
	npm run build

## Contributing

- Fork this repository
- Develop, push your changes to your fork
- Create a Pull Request in this repository with your changes

Currently, server-side development (PHP scripts) must be done on the web server because I don't have a test suite in place to mock the database and other PHP services.

## TODO

### General

- create a specification for DJ points

### Server

- Let's Encrypt auto-renewal
- replace MySQL queries with prepared statements/stored procedures
- polish database (remove HTML entities like `&amp;`, check for invalid values, etc.)
- upgrade MySQL and PHP to newest versions
- PHP implementation of RDS sender
- server-side authentication/redirect to /wizbif directory
- automated email for password reset, spaz sheet

### Client (public)

- develop unit tests with Karma and Jasmine
- add typeahead directive to any view with DJ name search
- try to integrate components into angular app:

```
	twitter social stream
	chat widget
	audio streams
```
- use DJ profile pics for schedule view
- add messages for empty content

### Client (private)

- make shows editable in schedule control panel
- add intern scheduler view
- carts control panel
- senior staff control panel
- album checkout interface
- interface to request/grant/deny access to intern status and show times
- maybe have account registration be approved
- user profile photos
- "spaz sheet" interface for logbook (with captcha)

#### Frontpage Ideas

- helpful bullet points
- points/rankings for teams and DJs
- announcements from senior staff
- minigame
