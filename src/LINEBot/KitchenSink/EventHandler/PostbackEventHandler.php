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

use PDO;
use LINE\LINEBot;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\Event\PostbackEvent;
use LINE\LINEBot\KitchenSink\EventHandler;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;

class PostbackEventHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var PostbackEvent $postbackEvent */
    private $postbackEvent;

    /**
     * PostbackEventHandler constructor.
     * @param LINEBot $bot
     * @param \Monolog\Logger $logger
     * @param PostbackEvent $postbackEvent
     */
    public function __construct($bot, $logger, PostbackEvent $postbackEvent)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->postbackEvent = $postbackEvent;
    }

    public function handle()
    {
//        $this->bot->replyText(
//            $this->postbackEvent->getReplyToken(),
//            'Got postback ' . $this->postbackEvent->getPostbackData()
//        );
error_log("---- PostbackEventHandler");
        $data=$this->postbackEvent->getPostbackData();
        error_log("     data: ".$data);
        $commands=explode("\n",$data);
        foreach ($commands as $command) {
            error_log("     command: ".$command);
        }

        switch ($commands[0]):
        case 'QANDA':
        $res=$this->bot->replyMessage(
            $this->postbackEvent->getReplyToken(),
            FlexMessageBuilder::builder()
                ->setAltText('問合せ')
                ->setContents(
                    CarouselContainerBuilder::builder()
                        ->setContents([
                            BubbleContainerBuilder::builder()
                                ->setHeader(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setContents([
                                            TextComponentBuilder::builder()
                                                ->setText('よくあるご質問')
                                        ])
                                )
                                ->setBody(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setSpacing(ComponentSpacing::SM)
                                        ->setContents([
                                            BoxComponentBuilder::builder()
                                                ->setLayout(ComponentLayout::VERTICAL)
                                                ->setContents([
                                                    TextComponentBuilder::builder()
                                                        ->setText('販売方法は?')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::XL)
                                                        ->setFlex(0),
                                                    TextComponentBuilder::builder()
                                                        ->setText('シューワでは、灯油は基本的に特定の曜日の決められたコースを巡回する巡回販売にて販売しております。')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::SM)
                                                        ->setFlex(0)
                                                ])
                                        ])
                                ),
                            BubbleContainerBuilder::builder()
                                ->setHeader(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setContents([
                                            TextComponentBuilder::builder()
                                                ->setText('よくあるご質問')
                                        ])
                                )
                                ->setBody(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setSpacing(ComponentSpacing::SM)
                                        ->setContents([
                                            BoxComponentBuilder::builder()
                                                ->setLayout(ComponentLayout::VERTICAL)
                                                ->setContents([
                                                    TextComponentBuilder::builder()
                                                        ->setText('支払い方法は?')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::XL)
                                                        ->setFlex(0),
                                                    TextComponentBuilder::builder()
                                                        ->setText("灯油早割サービス:クレジットカード払いのみお取り扱いをしております\n大口割引サービス:クレジット払い／現金払いの選択ができます。")
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::SM)
                                                        ->setFlex(0)
                                                ])
                                        ])
                                ),
                            BubbleContainerBuilder::builder()
                                ->setHeader(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setContents([
                                            TextComponentBuilder::builder()
                                                ->setText('よくあるご質問')
                                        ])
                                )
                                ->setBody(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setSpacing(ComponentSpacing::SM)
                                        ->setContents([
                                            BoxComponentBuilder::builder()
                                                ->setLayout(ComponentLayout::VERTICAL)
                                                ->setContents([
                                                    TextComponentBuilder::builder()
                                                        ->setText('ネットの注文方法は?')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::XL)
                                                        ->setFlex(0),
                                                    TextComponentBuilder::builder()
                                                        ->setText('トップページより新規会員登録をして頂き、ログイン後に表示される、注文画面よりご注文ください。')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::SM)
                                                        ->setFlex(0)
                                                ])
                                        ])
                                ),
                        ])
                )
        );
            break;
        }
        return;
        $userId=$this->postbackEvent->getUserId();
error_log("     userId: ".$userId);
        $stmt=$this->bot->pdo->prepare("SELECT * FROM Users WHERE userId=:userId");
        $stmt->bindParam(':userId',$userId,PDO::PARAM_STR);
        $stmt->execute();
        $row=$stmt->fetch();
error_log("2222222222");
        if ($row==null) {
error_log("    row==null");
            return;
        }
        $mode=$row['mode'];
        if ($mode==null) {
error_log("      mode==null");
        }
        if ($mode==2) {
            $postbackData=$this->postbackEvent->getPostbackData();
error_log("     postbackData: ".$postbackData);
            $dataArray=explode("\n",$postbackData);
if ($dataArray==FALSE) {
error_log("     dataArray==FALSE");
}
error_log("     dataArray: ".gettype($dataArray));
error_log("     dataArray: ".strval(count($dataArray)));
error_log("     dataArray[0]: ".$dataArray[0]);
error_log("     dataArray[1]: ".$dataArray[1]);
            $stmt=$this->bot->pdo->prepare("UPDATE Users SET mode=:mode,name=:name WHERE userId=:userId");
            $stmt->bindParam(':userId',$userId,PDO::PARAM_STR);
            $stmt->bindParam(':name',$dataArray[1],PDO::PARAM_STR);
            $stmt->bindValue(':mode',3,PDO::PARAM_INT);
            if ($stmt->execute()==TRUE) {
            error_log("OK OK OK OK OK");
            } else {
            error_log("NG NG NG NG NG");
            }
        }
    }
}
