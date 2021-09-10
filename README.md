# jfa-wp-ig-post (Wp Instagram Post)

This WordPress plugin allows you to retrieve a specific Instagram post and consume it via the REST API.

## Install

- Download the plugin from Github repository:
https://github.com/jfadev/jfa-wp-ig-post/archive/refs/heads/main.zip

- Upload the `jfa-wp-ig-post.zip` file to your Wordpress:
https://yoursite.com/wp-admin/plugin-install.php

- Activate the plugin.

- Click on Instagram Post menu button:

![Wp Instagram Post](menu.jpg?raw=true "Wp Instagram Post")

## Config

Enter https://instant-tokens.com and create the `API URL` of your instagram account.

For example:
`https://ig.instant-tokens.com/users/XXXXXX/instagram/XXXXXX/token?userSecret=XXXXX`

## Screenshot

![Wp Instagram Post](screenshot.jpg?raw=true "Wp Instagram Post")

## Endpoint

Access the post's JSON at the following endpoint:
`GET /wp-json/api/v2/instagram_post/post/`

##### Return
```
{
  "permalink": "https://www.instagram.com/p/XXXXXXXXXXXX/",
  "caption": "Caption text",
  "media_url": "https://scontent-ams4-1.cdninstagram.com/v/XXX/XXX.jpg?_nc_cat=X&ccb=1-5&_nc_sid=XX&_nc_ohc=XXX&_nc_ht=scontent-ams4-1.cdninstagram.com&edm=XXX",
  "url_token": "https://ig.instant-tokens.com/users/XXXXXX/instagram/XXXX/token.js?userSecret=XXXX",
  "username": "XXXXXXXX",
  "timestamp": "2020-12-14T20:12:36+0000"
}
```

## Contributors

- [Jordi Fernandes (@jfadev)](https://github.com/jfadev)