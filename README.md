# genesis-digital

<h1>Laravel Contact Demo</h1>

Install Instructions
<p>
I am assuming you have all the pre-requisite software installed. If not, then venture over to laravel and install the latest Homestead vagrant machine that is ready for you pre-built. 
</p>

<p>
Once you have created your machine and have the site defined in your host files (i.e. /etc/hosts) set up to point to the contacts demo to your local machine or VM. then download the source
</p>

<code>git clone https://github.com/dPhantum/genesis-digital.git</code>

<p>This will create the directory <code>genesis-digital</code> You must then <code>cd</code> into that directory, and
run the composer update to get the vendor pre-requisites.
</p>
<code> composer update </code>


<p>Copy the .env.exmaple file and rename it to .env and replace the text of "contacts.dev" with your domain name.</p>

<code>cp .env.example .env</code>

<p>
In the file .env change the items as seen here below, if you don't want to test the SSO functionality for any of the given items, below just remove their references, and be sure not to click on those links, because they will not redirect you correctly.
</p>  
  
<code><pre>
APP_NAME=ContactsDemo
APP_ENV=local
APP_KEY=base64:[YOUR_APP_KEY-AUTOFILLED]
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=[URL TO WHERE YOUR CODE IS RUNNING]

DB_CONNECTION=mysql
DB_HOST=[IP OR HOST NAME]
DB_PORT=3306
DB_DATABASE=[DATABASE NAME]
DB_USERNAME=[DB USERNAME]
DB_PASSWORD=[DB PASSWORD]

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=[IP OR NAME OF YOUR HOST - NOT USED IN THIS CODE]
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.[YOUR SMTP SERVER].com
MAIL_PORT=587
MAIL_USERNAME=[YOUR EMAIL ACCOUNT]
MAIL_PASSWORD=[YOUR EMAIL PWD]
MAIL_ENCRYPTION=[ENCRYPTION TYPE]

GITHUB_CLIENT_ID=[YOUR GITHUB CLIENT ID]
GITHUB_SECRET=[YOUR GITHUB SECRET]
GITHUB_REDIRECT=http://[YOUR WEB SITE LOCATION]/login/github/callback

FACEBOOK_CLIENT_ID=[YOUR CLIENT ID FOR FACEBOOK]
FACEBOOK_SECRET=[YOUR SECRET FOR FACEBOOK]
FACEBOOK_REDIRECT=http://[YOUR WEB SITE LOCATION]/login/facebook/callback

TWITTER_CLIENT_ID=[YOUR CLIENT ID FOR FACEBOOK]
TWITTER_SECRET=[YOUR SECRET FOR TWITTER]
TWITTER_REDIRECT=http://[YOUR WEB SITE LOCATION]/login/twitter/callback

LINKEDIN_CLIENT_ID=[YOUR CLIENT ID FOR FACEBOOK]
LINKEDIN_SECRET=[YOUR SECRET FOR LINKEDIN]
LINKEDIN_REDIRECT=http://[YOUR WEB SITE LOCATION]/login/linkedin/callback

GOOGLE_CLIENT_ID=[YOUR CLIENT ID FOR FACEBOOK]
GOOGLE_SECRET=[YOUR SECRET FOR GOOGLE]
GOOGLE_REDIRECT=http://[YOUR WEB SITE LOCATION]/login/google/callback

BITBUCKET_CLIENT_ID=[YOUR CLIENT ID FOR FACEBOOK]
BITBUCKET_SECRET=[YOUR SECRET FOR BITBUCKET]
BITBUCKET_REDIRECT=http://[YOUR WEB SITE LOCATION]/login/bitbucket/callback

</pre></code>


<p>
  Create the APP_KEY to place in the .env file this will be done automatically for you:
</p>

  <code> php artisan key:generate </code>


<p>
  The rest depends upon where you are installing. Hopefully, that should give you a jump start.
</p>

<p> Don't forget to create the database and run the database migrations:</p>

<p> Keep in mind if running under in a subdirectory on your machine (not in the root), you will need to change several files (config/app.php, and contacts.js and reassign the workingDir variable), and know what your doing, or the site will be broken.

<code>php artisan migrate:fresh</code>

<p> enjoy!</p>
<p>Cheers!<br>~Paul</p>
