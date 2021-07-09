<?php
	require_once __DIR__ . '/vendor/autoload.php';

	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

	$signature = $_SERVER['HTTP_'.\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
	echo $signature;

	$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

	log('token: '.getenv('CHANNEL_ACCESS_TOKEN'));
	foreach ($events as $event) {
		replyTextMessage($bot, $event->getReplyToken(), 'TextMessage');
	}



	function replyTextMessage($bot, $replyToken, $text) {

		$response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text));

		if (!$response->isSucceeded()) {
			error_log('Failed! '.$response->getHTTPStatus().' '.$response->getRawBody());
		}
	}

?>