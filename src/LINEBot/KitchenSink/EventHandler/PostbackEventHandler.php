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
use LINE\LINEBot\Event\PostbackEvent;
use LINE\LINEBot\KitchenSink\EventHandler;

use LINE\LINEBot\KitchenSink\EventHandler\MessageHandler\Flex\FlexMessageQA;
use LINE\LINEBot\KitchenSink\EventHandler\MessageHandler\Flex\FlexMessageQuestion;
use LINE\LINEBot\KitchenSink\EventHandler\MessageHandler\Flex\FlexMessageAnswer;

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
error_log("----- PostbackEventHandler");
        $data=$this->postbackEvent->getPostbackData();
error_log("      data: ".$data);
        switch ($data) {
        case 'QANDA':
            $flexMessageBuilder=FlexMessageQA::get();
error_log("xxxxx PostbackEventHandler");
            $this->bot->replyMessage($this->postbackEvent->getReplyToken(),$flexMessageBuilder);
            break;
        case 'CATEGORY1':
error_log("22222222222");
            $flexMessageBuilder=FlexMessageQuestion::get();
            $this->bot->replyMessage($this->postbackEvent->getReplyToken(),$flexMessageBuilder);
error_log("3333333333");
            break;
        case 'QUESTION1':
error_log("4444444444");
            $flexMessageBuilder=FlexMessageAnswer::get();
            $this->bot->replyMessage($this->postbackEvent->getReplyToken(),$flexMessageBuilder);
error_log("55555555555");
            break;
        }
error_log("+++++ PostbackEventHandler");
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
