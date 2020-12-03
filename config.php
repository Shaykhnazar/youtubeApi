<?php
require_once 'vendor/autoload.php';
$developer_key = 'YOUR_API_KEY_HERE';

$client = new Google_Client();
$client->setDeveloperKey($developer_key);

// Define service object for making API requests.
$service = new Google_Service_YouTube($client);

$queryParams = [
    'id' => 'YOUR_CHANNEL_ID_HERE'
];

//$response = $service->channels->listChannels('snippet,contentDetails,statistics', $queryParams);
$playlists = $service->playlists->listPlaylists('snippet',$queryParams);
$videos = $service->videos->listVideos('snippet',$queryParams);
//print_r($playlists);
print_r($videos);
//$items = $response->items;
//foreach ($items as $item){
//    echo "<pre>". $item->id . "</pre>";
//}
