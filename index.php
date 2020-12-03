<?php
$baseUrl = 'https://www.googleapis.com/youtube/v3/';
// https://developers.google.com/youtube/v3/getting-started
$apiKey = 'YOUR_API_KEY_HERE';
// If you don't know the channel ID see below
$channelId = 'YOUR_CHANNEL_ID_HERE';

$params = [
    'id'=> $channelId,
    'part'=> 'contentDetails',
    'key'=> $apiKey
];
$url = $baseUrl . 'channels?' . http_build_query($params);
$json = json_decode(file_get_contents($url), true);

$playlist = $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

$params = [
    'part'=> 'snippet',
    'playlistId' => $playlist,
    'maxResults'=> '50',
    'key'=> $apiKey
];
$url = $baseUrl . 'playlistItems?' . http_build_query($params);
$json = json_decode(file_get_contents($url), true);

$videos = [];
foreach($json['items'] as $video)
    $videos[] = [
        'id'=>$video['snippet']['resourceId']['videoId'],
        'title'=>$video['snippet']['title'],
        'description'=>$video['snippet']['description']
    ];

while(isset($json['nextPageToken'])){
    $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
    $json = json_decode(file_get_contents($nextUrl), true);
    foreach($json['items'] as $video)
        $videos[] = [
            'id'=>$video['snippet']['resourceId']['videoId'],
            'title'=>$video['snippet']['title'],
            'description'=>$video['snippet']['description']
        ];
}
$h = fopen('files/videos.txt', 'r+');
fwrite($h, var_export($videos, true));
print_r($videos);