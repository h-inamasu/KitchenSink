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
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;

use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;

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
        $userId=$this->followEvent->getUserId();
        $stmt=$pdo->query("INSERT INTO Users (userid,mode) VALUES ('$userId',1)");
        $stmt=$pdo->query("INSERT INTO Users (userid,mode) VALUES ('0000000000',10)");

        $message1="友達登録ありがとう御座います！\n".
                  "これからお得な情報を配信していきますので、ご期待ください！\n".
                  "またLINEから灯油のご注文も可能となりましたので、是非ご利用ください！";
        $message2="まずはご利用頂くにあたり、お客様情報のご入力をお願いいたします。";
        $message3="まずはお名前をご入力ください。";
        //$this->bot->replyText($this->followEvent->getReplyToken(),$message1,$message2,$message3);
        //$this->bot->replyText($this->followEvent->getReplyToken(),$message1,$message2);
                $this->bot->replyMessage(
                    $this->followEvent->getReplyToken(),
                    new TemplateMessageBuilder(
                        'Confirm alt text',
                        new ConfirmTemplateBuilder('Do it?', [
                            new MessageTemplateActionBuilder('Yes', 'Yes!'),
                            new MessageTemplateActionBuilder('No', 'No!'),
                        ])
                    )
                );
error_log("0000000000");

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
                        new RichMenuAreaBuilder(
                            new RichMenuAreaBoundsBuilder(0,0,1250,1686),
                        //    new MessageTemplateActionBuilder('お問い合わせ','お問い合わせ')
                            new PostbackTemplateActionBuilder('お問い合わせ','QANDA',null)
                        ),
                        new RichMenuAreaBuilder(
                            new RichMenuAreaBoundsBuilder(1251,0,1250,1686),
                            //new MessageTemplateActionBuilder('注文','注文')
                            new PostbackTemplateActionBuilder('注文','ORDER',null)
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
            //$res=$this->bot->uploadRichMenuImage($richMenuId,'/app/rich_menu.png','image/png');
            $res=$this->bot->uploadRichMenuImage($richMenuId,'/app/richmenu2500_1686.png','image/png');
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

        error_log("----- Completed");
    }
}
