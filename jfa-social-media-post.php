<?php

/**
 * Plugin Name: Jfa Social Media Post
 * Plugin URI: https://jordifernandes.com/jfa-social-media-post/
 * Description: This WordPress plugin allows you to retrieve a specific Instagram post and consume it via the REST API.
 * Version: 1.0
 * Author: Jordi Fernandes Alves
 * Author URI: https://jordifernandes.com/
 **/

/**
 * Admin menu
 */
add_action('admin_menu', function () {
  add_menu_page(
    'Jfa Social Media Post',
    'Social Post',
    'publish_posts', //'manage_options', // https://wordpress.org/support/article/roles-and-capabilities/
    'social_media_post',
    'admin_social_media_post_page',
    'dashicons-instagram'
  );
});

/**
 * Admin page
 */
function admin_social_media_post_page()
{
  $settings = social_media_post_settings_get();
?>
  <div class="wrap">
    <h1 class="wp-heading-inline">
      Jfa Social Media Post
    </h1>
    <p>This plugin allows you to retrieve a specific Instagram post.</p>
    <div style="padding:10px;">
      <div style="display:grid;grid-template-columns:repeat(3, 1fr);grid-gap:10px;grid-auto-rows:minmax(100px, auto);">
        <div style="grid-column:1/3;grid-row:1;">
          <form id="instagram-post-form" method="post" action="/wp-json/api/v2/social_media_post/settings/">
            <h2>Config</h2>
            <p>
              Enter the API URL of the <a href="https://instant-tokens.com" target="_blank">instant-tokens.com</a> instagram account<br>
              For example:<br>
              <code>https://ig.instant-tokens.com/users/XXXXXX/instagram/XXXXXX/token?userSecret=XXXXX</code>
            </p>
            <label for="url_token">Instant Token API URL:</label><br>
            <input type="url" name="url_token" value="<?php echo $settings->url_token ?>" style="width:418px">
            <h2>Post displayed</h2>
            <p>
              Enter the URL of the Instagram post to be displayed (post must belong to the user's account)<br>
              For example:<br>
              <code>https://www.instagram.com/p/XXXXXXXXXX/</code>
            </p>
            <label for="permalink">URL:</label><br>
            <input type="url" name="permalink" value="<?php echo $settings->permalink ?>" style="width:300px">
            <button type="submit" class="button button-primary">
              Save changes
            </button>
          </form>
          <h2>Endpoint</h2>
          <p>Access the post's JSON at the following endpoint.</p>
          <p><code>/wp-json/api/v2/social_media_post/post/</code> <a href="/wp-json/api/v2/social_media_post/post/" target="_blank">view</a></p>
          <p>Return:<br>
          <code>{"permalink":"", "caption":"", "media_url":"", "url_token":"", "username":"", "timestamp":""}</code>
          <h2>Info</h2>
          Homepage: <a href="https://jordifernandes.com/jfa-social-media-post/" target="_blank">https://jordifernandes.com/jfa-social-media-post/</a><br> 
          Donate: <a href="https://jordifernandes.com/donate/" target="_blank">https://jordifernandes.com/donate/</a><br>
        </div>
        <div style="grid-column:3;grid-row:1;">
          <?php if ($settings && $settings->media_url) { ?>
            <h3>Preview: </h3>
            <img src="<?php echo $settings->media_url ?>" width="200px"><br><br>
            <b>Permalink: </b><br>
            <a href="<?php echo $settings->permalink ?>" target="_blank">
              <?php echo $settings->permalink ?>
            </a><br><br>
            <b>Username: </b>
            <a href="<?php echo "https://www.instagram.com/{$settings->username}/" ?>" target="_blank">
              @<?php echo $settings->username ?>
            </a><br><br>
            <b>Date: </b>
            <?php echo $settings->timestamp ?><br><br>
            <b>Caption: </b><br>
            <?php echo $settings->caption ?>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php
}

/**
 * Add endpoint to save config
 */
add_action('rest_api_init', function () {
  register_rest_route('api/v2', '/social_media_post/settings/', [
    'methods' => 'POST',
    'callback' => 'api_social_media_post_settings'
  ]);
});

function api_social_media_post_settings($data)
{
  if ($data['permalink'] && $data['url_token']) {
    $access_token = file_get_contents($data['url_token']);
    preg_match("/\'(.*)\'/", $access_token, $matches);
    $access_token = $matches[1];
    $fields = 'id,caption,media_url,permalink,username,timestamp';
    $limit = '1000000';
    $endpoint = "https://graph.instagram.com/me/media?fields=$fields&access_token=$access_token&limit=$limit";
    $res = json_decode(file_get_contents($endpoint));
    foreach ($res->data as $post) {
      if ($post->permalink == $data['permalink']) {
        break;
      }
    }
    $settings = [
      'permalink' => $post->permalink,
      'caption' => $post->caption,
      'media_url' => $post->media_url,
      'url_token' => $data['url_token'],
      'username' => $post->username,
      'timestamp' => $post->timestamp,
    ];
    social_media_post_settings_set($settings);
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
  }
}

/**
 * Add endpoint to retrieve post json
 */
add_action('rest_api_init', function () {
  register_rest_route('api/v2', '/social_media_post/post/', [
    'methods' => 'GET',
    'callback' => 'api_social_media_post_post'
  ]);
});

function api_social_media_post_post()
{
  return social_media_post_settings_get(true);
}

function social_media_post_settings_get($from_api = false)
{
  $pre = $from_api ? '' : '../';
  $json = file_get_contents($pre . 'wp-content/plugins/jfa-social-media-post/data.json');
  return json_decode($json);
}

function social_media_post_settings_set($obj)
{
  file_put_contents('wp-content/plugins/jfa-social-media-post/data.json', json_encode($obj));
}
