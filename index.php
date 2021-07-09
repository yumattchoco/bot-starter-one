<?php
	require_once __DIR__ . '/vendor/autoload.php';

	$httpClient = new LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

	$bot = new LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

	$signature = $_SERVER['HTTPS_'.\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

	$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

	foreach ($events as $event) {
		replyTextMessage($bot, $event->getReplyToken(), 'TextMessage');
	}



	function replyTextMessage($bot, $replyToken, $text) {

		$response = $bot->replyMessage($replyToken, new \LINE\LINEbot\MessageBuilder\TextMessageBilder($text));

		if (!$response->is_succeeded()) {
			error_log('Failed!'.$response->getHTTPStatus.' '.$response->getRawBody());
		}
	}

?>