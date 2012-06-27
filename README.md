
# Feedback

Feedback is a JavaScript/PHP powered contact form that is docked in a tab on the left side of the screen and slides out when needed.

The backend is built on the Silex PHP micro-framework with Twig templates. Due to reliance on XHR requests, the backend must be installed on the hostname where the client is used.

## Requirements

 * PHP 5.3
 * Must be installed on the same hostname (unless you use an XHR proxy).
 * [Composer](http://getcomposer.org/) for installing dependencies

## Installation & Deployment

 1. Clone the repo onto your localhost document root
 1. Use Composer to install dependencies: `php composer.phar install`
 1. Verify your install works by opening http://localhost/path/to/Feedback/demo/
 1. Edit `config.php` to specify your e-mail address, and customize `static/style.css` and the templates in `app/views` to meet your needs.
 1. Copy Feedback to your production server.
 1. Place a script element near the bottom of your pages: `<script src="path/to/Feedback/index.php/"></script>`

## Design

The page's script element includes the Feedback stylesheet, and creates the Feedback tab. When the user clicks to open the form, a fresh form is loaded from "Feedback/form" and the form slides into place. The user's submission is sent to "Feedback/send", which sends the email and responds with replacement HTML. The user can then close the tab.

## Configuration Files

 * **config.php** : Some e-mail/environment configuration.
 * **app/view/jsConfig.twig** : title and dimensions of the "Feedback" IMG element
 * **app/view/form.twig** : the HTML form displayed to the client
 * **app/view/mailFormat.twig** : formatting of e-mail sent
 * **app/view/mail.twig** : HTML that replaces form on successful submission
 * **app/view/error.twig** : HTML that replaces form on unsuccessful submission
 * **static/style.css** : CSS applied to elements inside #Feedback

### License

Feedback has a permissive, "modified BSD" license:

Copyright (c) 2011, [Stephen Clay](http://www.mrclay.org/) and other collaborators
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
* Neither the name Stephen Clay nor the names of his contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE AFOREMENTIONED PARTIES BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.