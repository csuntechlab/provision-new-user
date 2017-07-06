# provision-new-user
Google API application to provision a new user account and send out everything per the on-boarding process

## Prerequisites

You must have already registered this as a Google application in the organization

1) Download your client secret and store it in `storage/secret/client_secrets.json`

1) Enable Gmail API for this Google application (provisioning users)

2) Enable Admin SDK for this Google Application (sending email automatically)

## Workflow

1) Go to `/oauth/authorize` and you will be redirected to the Google OAuth screen

2) Successful authorization redirects to `/oauth/authorized` and then to `/provision/new`

## Useful Links

Google API PHP client library: https://developers.google.com/api-client-library/php

Using OAuth 2.0 for Web Server Applications: https://developers.google.com/api-client-library/php/auth/web-app

Managing User Accounts: https://developers.google.com/admin-sdk/directory/v1/guides/manage-users

Gmail API: https://developers.google.com/gmail/api/

Gmail API PHP Quickstart: https://developers.google.com/gmail/api/quickstart/php