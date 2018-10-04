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
//        $code='10008d';
//        $bin=hex2bin(str_repeat('0',8-strlen($code)).$code);
//        $moonGrin=mb_convert_encoding($bin,'UTF-8','UTF-32BE');
//        $code='100079';
//        $bin=hex2bin(str_repeat('0',8-strlen($code)).$code);
//        $hahaha=mb_convert_encoding($bin,'UTF-8','UTF-32BE');
//        $code='100090';
//        $bin=hex2bin(str_repeat('0',8-strlen($code)).$code);
//        $content=mb_convert_encoding($bin,'UTF-8','UTF-32BE');
//        $message="お友達登録ありがとうございます".$moonGrin."\n" .
//                 "いつでもお気軽にお問い合わせメッセージをお送りください！".$hahaha."\n".
//                 "シューワのお水をご利用中のお客様は\n" .
//                 "■お客様番号（チラシに記載の番号）\n" .
//                 "このメッセージにお送りください！\n" .
//                 "お送り頂いた方にはもれなくお水12ℓ一本プレゼント！\n" .
//                 "みなさまのご返信おまちしております".$content;
        $pdo=$this->bot->pdo;
        $stmt=$pdo->query("INSERT INTO Users (userid,mode) VALUES ($this->followEvent->getUserId(),1)");
error_log("0000000000");

        $message1="友達登録ありがとう御座います！\n".
                  "これからお得な情報を配信していきますので、ご期待ください！\n".
                  "またLINEから灯油のご注文も可能となりましたので、是非ご利用ください！\n";
        $message2="まずはご利用頂くにあたり、お客様情報のご入力をお願いいたします。";
        $message3="まずはお名前をご入力ください。";
        $this->bot->replyText($this->followEvent->getReplyToken(),$message1,$message2,$message3);

        if (FALSE) {
        error_log("----- Richmenu");
        $richMenuName='Rich Menu Name';
        $richMenuFound=FALSE;
        $richMenuId='';
        $res=$this->bot->getRichMenuList();
        $httpStatus=$res->getHTTPStatus();
        $val=strval($httpStatus);
        error_log("      getRichMenuList HTTP ".$val);

        $json=$res->getJSONDecodedBody();
        $richmenus=$json['richmenus'];
        error_log("      count: ".strval(count($richmenus)));
        foreach ($richmenus as $richmenu=>$value) {
            $id=$value['richMenuId'];
            error_log("      richMenuId: ".$id);
            $name=$value['name'];
            error_log("      name: ".$name);
            if (strcmp($name,$richMenuName)==0) {
                error_log("      Found rich menu already created (".$name.")");
                $richMenuFound=TRUE;
                $richMenuId=$id;
            }
        }

        if ($richMenuFound==FALSE) {
            error_log("----- Create Richmenu");
            $res=$this->bot->createRichMenu(
                new RichMenuBuilder(
                    RichMenuSizeBuilder::getFull(),
                    true,
                    $richMenuName,
                    'Tap to open',
                    [
                        //new RichMenuAreaBuilder(
                        //    new RichMenuAreaBoundsBuilder(0,10,125,1676),
                        //    new MessageTemplateActionBuilder('message label','test message')
                        //),
                        //new RichMenuAreaBuilder(
                        //    new RichMenuAreaBoundsBuilder(1250,0,1240,1686),
                        //    new MessageTemplateActionBuilder('message label 2','test message 2')
                        //)
                        new RichMenuAreaBuilder(
                            new RichMenuAreaBoundsBuilder(551,325,321,321),
                            new MessageTemplateActionBuilder('message label 1','test message 1')
                        ),
                        new RichMenuAreaBuilder(
                            new RichMenuAreaBoundsBuilder(876,651,321,321),
                            new MessageTemplateActionBuilder('message label 2','test message 2')
                        ),
                        new RichMenuAreaBuilder(
                            new RichMenuAreaBoundsBuilder(551,972,321,321),
                            new MessageTemplateActionBuilder('message label 3','test message 3')
                        ),
                        new RichMenuAreaBuilder(
                            new RichMenuAreaBoundsBuilder(225,651,321,321),
                            new MessageTemplateActionBuilder('message label 4','test message 4')
                        ),
                        new RichMenuAreaBuilder(
                            new RichMenuAreaBoundsBuilder(1433,657,367,367),
                            new MessageTemplateActionBuilder('message label 5','test message 5')
                        ),
                        new RichMenuAreaBuilder(
                            new RichMenuAreaBoundsBuilder(1907,657,367,367),
                            new MessageTemplateActionBuilder('message label 6','test message 6')
                        )
                    ]
                )
            );
            $httpStatus=$res->getHTTPStatus();
            $val=strval($httpStatus);
            error_log("      createRichMenu HTTP ".$val);

            error_log("----- Get Richmenu id");
            $richMenuId=$res->getJSONDecodedBody()['richMenuId'];
            error_log("     richMenuId=".$richMenuId);

            error_log("----- Upload Richmenu Image");
            $res=$this->bot->uploadRichMenuImage($richMenuId,'/app/rich_menu.png','image/png');
            $httpStatus=$res->getHTTPStatus();
            $val=strval($httpStatus);
            error_log("      uploadRichMenuImage HTTP ".$val);
        }

        error_log("----- Link Richmene to User");
        $userId=$this->followEvent->getUserId();
        error_log("      User Id=".$userId);
        error_log("      Richmenu Id=".$richMenuId);
        $res=$this->bot->getRichMenuId($userId);
        $httpStatus=$res->getHTTPStatus();
        $val=strval($httpStatus);
        error_log("      getRichMenuId HTTP ".$val);
        $res=$this->bot->linkRichMenu($userId,$richMenuId);
        $httpStatus=$res->getHTTPStatus();
        $val=strval($httpStatus);
        error_log("      linkRichMenu HTTP ".$val);
        }

        error_log("----- Completed");
    }
}
