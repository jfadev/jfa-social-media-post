# jfa-social-media-post (Jfa Social Media Post)

This WordPress plugin allows you to retrieve a specific Instagram post and consume it via the REST API.
Homepage: [https://jordifernandes.com/jfa-social-media-post/](https://jordifernandes.com/jfa-social-media-post/)

## Install

In your Wordpress menu go to `Plugins > Add New` and search: `Jfa Social Media Post`

Or

- Download the plugin from Github repository:
https://github.com/jfadev/jfa-social-media-post/archive/refs/heads/main.zip

- Rename to `jfa-social-media-post.zip` the file.

- Upload the `jfa-social-media-post.zip` file to your Wordpress:
https://yoursite.com/wp-admin/plugin-install.php

- Activate the plugin.

- Click on `Social Post` menu button:

![Social Media Post](assets/menu.jpg?raw=true "Social Media Post")

## Config

Enter https://instant-tokens.com and create the `API URL` of your instagram account.

For example:
`https://ig.instant-tokens.com/users/XXXXXX/instagram/XXXXXX/token?userSecret=XXXXX`

## Screenshot

![Social Media Post](assets/screenshot-1.jpg?raw=true "Social Media Post")

## Endpoint

Access the post's JSON at the following endpoint:
`GET /wp-json/api/v2/social_media_post/post/`

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

## Donate

[https://jordifernandes.com/donate/](https://jordifernandes.com/donate/)

## License

[MIT License](LICENSE)

## Contributors

- [Jordi Fernandes (@jfadev)](https://github.com/jfadev)