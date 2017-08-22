<?php
/**
 * Created by PhpStorm.
 * User: al73r
 * Date: 4/13/2017
 * Time: 10:58 PM
 */
$accessToken = 'EAADNyHdzFaoBAJjcJOn8hLHcwcgcYzIQ3ZBGdC2ijdzjvZAZBL7mwkVYcX6f3GlojAuLdZClY8Guuf8sFkd5ZCuGeIh1b6ZAeUCid9wZAocrp0ZBwRTZAfd8A2NLN41BbW0sse2dZA04VLZBV3WkqTOBsGc';
$resp = file_get_contents("https://graph.facebook.com/v2.8/".$_GET["id"]."?fields=albums.limit(5){name,photos.limit(2){name,picture,images}},posts.limit(5){message,created_time}&access_token=".$accessToken);
echo $resp;
