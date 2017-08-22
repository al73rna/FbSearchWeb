<?php
/**
 * Created by PhpStorm.
 * User: al73r
 * Date: 4/2/2017
 * Time: 5:54 PM
 */

require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
$accessToken = 'EAADNyHdzFaoBAJjcJOn8hLHcwcgcYzIQ3ZBGdC2ijdzjvZAZBL7mwkVYcX6f3GlojAuLdZClY8Guuf8sFkd5ZCuGeIh1b6ZAeUCid9wZAocrp0ZBwRTZAfd8A2NLN41BbW0sse2dZA04VLZBV3WkqTOBsGc';
$fb = new Facebook\Facebook([
    'app_id' => '226260881184170',
    'app_secret' => 'b6187cbf087d05cb651954e67c3f7aaa',
    'default_graph_version' => 'v2.5',
]);
$fb->setDefaultAccessToken($accessToken);
$ddd= "";
class cursor {
    public $hasnext;
    public $hasper;
    public $data;
}
if($_GET['type']!=='place'){
    try {

        $response = $fb->get('/search?q='.$_GET['value'].'&type='.$_GET['type']);
        $nextP = $fb->next($response->getGraphEdge());
        if(intval($_GET['page'])==1){
            //echo $response->getGraphEdge()->asJson();
            $ddd= json_decode($response->getGraphEdge());
            $tmp = new cursor();
            if(is_null($fb->next($response->getGraphEdge()))){$tmp->hasnext="false";}else{$tmp->hasnext="true";}
            if(is_null($fb->previous($response->getGraphEdge()))){$tmp->hasper="false";}else{$tmp->hasper="true";}
            $tmp->data = $ddd;
            echo json_encode($tmp);
        }
        else{
            for($i=2 ; $i<intval($_GET['page'])+1; $i++){
                if($i == intval($_GET['page'])){
                    $ddd= json_decode($nextP);
                    $tmp = new cursor();
                    if(is_null($fb->next($nextP))){$tmp->hasnext="false";}else{$tmp->hasnext="true";}
                    if(is_null($fb->previous($nextP))){$tmp->hasper="false";}else{$tmp->hasper="true";}
                    $tmp->data = $ddd;
                    echo json_encode($tmp);
                }

                $nextP = $fb->next($nextP);
            }

        }


    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
} else{

    $resp = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_GET['value']).'&key=AIzaSyB_SpDMg1q02Mh2yqztNM_NQCQVNMKcYa0');
    $garray = json_decode($resp, true);
    $lat=  $garray['results'][0]['geometry']['location']['lat'];
    $lng= $garray['results'][0]['geometry']['location']['lng'];

    try {
        $response = $fb->get('/search?q='.$_GET['value'].'&type='.$_GET['type'].'&center='.$lat.','.$lng);
        $nextP = $fb->next($response->getGraphEdge());

        if(intval($_GET['page'])==1){
            //echo $response->getGraphEdge()->asJson();
            $ddd= json_decode($response->getGraphEdge());
            $tmp = new cursor();
            if(is_null($fb->next($response->getGraphEdge()))){$tmp->hasnext="false";}else{$tmp->hasnext="true";}
            if(is_null($fb->previous($response->getGraphEdge()))){$tmp->hasper="false";}else{$tmp->hasper="true";}
            $tmp->data = $ddd;
            echo json_encode($tmp);
        }
        else {
            for ($i = 2; $i < intval($_GET['page']) + 1; $i++) {
                if ($i == intval($_GET['page'])) {
                    $ddd = json_decode($nextP);
                    $tmp = new cursor();
                    if (is_null($fb->next($nextP))) {
                        $tmp->hasnext = "false";
                    } else {
                        $tmp->hasnext = "true";
                    }
                    if (is_null($fb->previous($nextP))) {
                        $tmp->hasper = "false";
                    } else {
                        $tmp->hasper = "true";
                    }
                    $tmp->data = $ddd;
                    echo json_encode($tmp);
                }

                $nextP = $fb->next($nextP);
            }
        }

    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
}


