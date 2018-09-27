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

error_log("---------- BEGIN");
        $res=$this->bot->createRichMenu(
            new RichMenuBuilder(
                RichMenuSizeBuilder::getFull(),
                true,
                'Nice richmenu',
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
error_log("---------- END");
    }
}
