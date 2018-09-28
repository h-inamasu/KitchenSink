<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace LINE\LINEBot\KitchenSink\EventHandler;

use LINE\LINEBot;
use LINE\LINEBot\Event\FollowEvent;
use LINE\LINEBot\KitchenSink\EventHandler;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;

class FollowEventHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var FollowEvent $followEvent */
    private $followEvent;

    /**
     * FollowEventHandler constructor.
     * @param LINEBot $bot
     * @param \Monolog\Logger $logger
     * @param FollowEvent $followEvent
     */
    public function __construct($bot, $logger, FollowEvent $followEvent)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->followEvent = $followEvent;
    }

    public function handle()
    {
        $code='10008d';
        $bin=hex2bin(str_repeat('0',8-strlen($code)).$code);
        $moonGrin=mb_convert_encoding($bin,'UTF-8','UTF-32BE');
        $code='100079';
        $bin=hex2bin(str_repeat('0',8-strlen($code)).$code);
        $hahaha=mb_convert_encoding($bin,'UTF-8','UTF-32BE');
        $code='100090';
        $bin=hex2bin(str_repeat('0',8-strlen($code)).$code);
        $content=mb_convert_encoding($bin,'UTF-8','UTF-32BE');
        $message="お友達登録ありがとうございます".$moonGrin."\n" .
                 "いつでもお気軽にお問い合わせメッセージをお送りください！".$hahaha."\n".
                 "シューワのお水をご利用中のお客様は\n" .
                 "■お客様番号（チラシに記載の番号）\n" .
                 "このメッセージにお送りください！\n" .
                 "お送り頂いた方にはもれなくお水12ℓ一本プレゼント！\n" .
                 "みなさまのご返信おまちしております".$content;

        $this->bot->replyText($this->followEvent->getReplyToken(),$message);

error_log("----- Create Richmenu");
        $richMenuName='Rich Menu Name';
        $res=$this-bot->getRichMenuList();
$httpStatus=$res->getHTTPStatus();
$val=strval($httpStatus);
error_log("      getRichMenuList() HTTP ".$val);
return;
if ($res->getHTTPStatus()==200) {
//error_log("      getRichMenuList HTTP 200");
//} else {
//error_log("      getRichMenuList HTTP ".strval($res->getHTTPStatus());
//}
//        $json=$res->getJSONDecodedBody();
//        $richmenus=$json['richmenus'];
//error_log("      count: ".strval(count($richmenus)));
//        foreach ($richmenus as $richmenu=>$value) {
//            $richMenuId=$value['richMeniId'];
//error_log("      richMenuId: ".$richMenuId);
//            $richMenuName=$value['name'];
//error_log("      richMenuName: ".$richMenuName);
//        }
        $res=$this->bot->createRichMenu(
            new RichMenuBuilder(
                RichMenuSizeBuilder::getFull(),
                true,
                $richMenuName,
                'Tap to open',
                [
                    new RichMenuAreaBuilder(
                        new RichMenuAreaBoundsBuilder(0,10,125,1676),
                        new MessageTemplateActionBuilder('message label','test message')
                    ),
                    new RichMenuAreaBuilder(
                        new RichMenuAreaBoundsBuilder(1250,0,1240,1686),
                        new MessageTemplateActionBuilder('message label 2','test message 2')
                    )
                ]
            )
        );
if ($res->getHTTPStatus()==200) {
error_log("     createRichMenu HTTP status 200");
} else {
$val=strval($res->getHTTPStatus());
error_log("     createRichMenu HTTP status ".$val);
}
//if ($res->isSucceeded()==true) {
//error_log("     isSucceeded=true");
//}
//if ($res->getJSONDecodedBody()['status']==200) {
//error_log("JSON 200");
//}
error_log("----- Get Richmenu id");
        $richMenuId=$res->getJSONDecodedBody()['richMenuId'];
error_log("     richMenuId=".$richMenuId);
error_log("----- Upload Richmenu Image");
	$res=$this->bot->uploadRichMenuImage($richMenuId,'/app/rich_menu.png','image/png');
//if ($res->getHTTPStatus()==200) {
//error_log("     HTTP staus=200");
//}
//if ($res->isSucceeded()==true) {
//error_log("     isSucceeded=true");
//}
//if ($res->getJSONDecodedBody()['status']==200) {
//error_log("JSON 200");
//}
error_log("----- Get User Id");
        $userId=$this->followEvent->getUserId();
error_log("      User Id=".$userId);
error_log("      Richmenu Id=".$richMenuId);
error_log("----- Link Richmene to User");
        $res=$this->bot->getRichMenuId($userId);
if ($res->getHTTPStatus()==200) {
error_log("     HTTP staus=200");
} else {
$val=strval($res->getHTTPStatus());
error_log("     HTTP status=".$val);
}
        $res=$this->bot->linkRichMenu($userId,$richMenuId);
if ($res->getHTTPStatus()==200) {
error_log("     HTTP staus=200");
} else {
$val=strval($res->getHTTPStatus());
error_log("     HTTP status=".$val);
}
if ($res->isSucceeded()==true) {
error_log("     isSucceeded=true");
}
if ($res->getJSONDecodedBody()['status']==200) {
error_log("JSON 200");
}
error_log("----- Completed");
    }
}
