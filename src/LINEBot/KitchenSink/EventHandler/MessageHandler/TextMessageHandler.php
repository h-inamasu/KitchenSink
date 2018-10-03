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

namespace LINE\LINEBot\KitchenSink\EventHandler\MessageHandler;

use PDO;
use LINE\LINEBot;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\KitchenSink\EventHandler;
use LINE\LINEBot\KitchenSink\EventHandler\MessageHandler\Flex\FlexSampleRestaurant;
use LINE\LINEBot\KitchenSink\EventHandler\MessageHandler\Flex\FlexSampleShopping;
use LINE\LINEBot\KitchenSink\EventHandler\MessageHandler\Util\UrlBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;

use LINE\LINEBot\Constant\Flex\ComponentLayout;
use PHPUnit\Framework\TestCase;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\Constant\Flex\ComponentButtonStyle;
use LINE\LINEBot\Constant\Flex\ComponentButtonHeight;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpacerComponentBuilder;
use LINE\LINEBot\Constant\Flex\ComponentSpaceSize;
use LINE\LINEBot\Constant\Flex\ComponentGravity;

class TextMessageHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var \Slim\Http\Request $logger */
    private $req;
    /** @var TextMessage $textMessage */
    private $textMessage;

    /**
     * TextMessageHandler constructor.
     * @param $bot
     * @param $logger
     * @param \Slim\Http\Request $req
     * @param TextMessage $textMessage
     */
    public function __construct($bot, $logger, \Slim\Http\Request $req, TextMessage $textMessage)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->req = $req;
        $this->textMessage = $textMessage;
    }

    public function handle()
    {
        $text = $this->textMessage->getText();
        $replyToken = $this->textMessage->getReplyToken();
        $this->logger->info("Got text message from $replyToken: $text");

        switch ($text) {
            case 'qa1':
error_log("----- QA1");
        $res=$this->bot->replyMessage(
            $replyToken,
            FlexMessageBuilder::builder()
                ->setAltText('Q&A')
                ->setContents(
                    CarouselContainerBuilder::builder()
                        ->setContents([
                            BubbleContainerBuilder::builder()
                                ->setHeader(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setContents([
                                            TextComponentBuilder::builder()
                                                ->setText('Q&A')
                                        ])
                                )
                                //->setHero(
                                //    ImageComponentBuilder::builder()
                                //        ->setSize(ComponentImageSize::FULL)
                                //        ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
                                //        ->setAspectMode(ComponentImageAspectMode::COVER)
                                //        ->setUrl('https://example.com/photo1.png')
                                //)
                                ->setBody(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setSpacing(ComponentSpacing::SM)
                                        ->setContents([
                                            TextComponentBuilder::builder()
                                                ->setText('Arm Chair, White')
                                                ->setWrap(true)
                                                ->setWeight(ComponentFontWeight::BOLD)
                                                ->setSize(ComponentFontSize::XL),
                                            BoxComponentBuilder::builder()
                                                ->setLayout(ComponentLayout::BASELINE)
                                                ->setContents([
                                                    TextComponentBuilder::builder()
                                                        ->setText('$49')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::XL)
                                                        ->setFlex(0),
                                                    TextComponentBuilder::builder()
                                                        ->setText('.99')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::SM)
                                                        ->setFlex(0)
                                                ])
                                        ])
                                )
                                ->setFooter(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setSpacing(ComponentSpacing::SM)
                                        ->setContents([
                                            ButtonComponentBuilder::builder()
                                                ->setStyle(ComponentButtonStyle::PRIMARY)
                                                ->setAction(
                                                    new UriTemplateActionBuilder(
                                                        'Add to Cart',
                                                        'https://example.com'
                                                    )
                                                ),
                                            ButtonComponentBuilder::builder()
                                                ->setAction(
                                                    new UriTemplateActionBuilder(
                                                        'Add to wishlist',
                                                        'https://example.com'
                                                    )
                                                )
                                        ])
                                ),
                            BubbleContainerBuilder::builder()
                                ->setHero(
                                    ImageComponentBuilder::builder()
                                        ->setSize(ComponentImageSize::FULL)
                                        ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
                                        ->setAspectMode(ComponentImageAspectMode::COVER)
                                        ->setUrl('https://example.com/photo2.png')
                                )
                                ->setBody(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setSpacing(ComponentSpacing::SM)
                                        ->setContents([
                                            TextComponentBuilder::builder()
                                                ->setText('Metal Desk Lamp')
                                                ->setWrap(true)
                                                ->setWeight(ComponentFontWeight::BOLD)
                                                ->setSize(ComponentFontSize::XL),
                                            BoxComponentBuilder::builder()
                                                ->setLayout(ComponentLayout::BASELINE)
                                                ->setContents([
                                                    TextComponentBuilder::builder()
                                                        ->setText('$11')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::XL)
                                                        ->setFlex(0),
                                                    TextComponentBuilder::builder()
                                                        ->setText('.99')
                                                        ->setWrap(true)
                                                        ->setWeight(ComponentFontWeight::BOLD)
                                                        ->setSize(ComponentFontSize::SM)
                                                        ->setFlex(0)
                                                ]),
                                            TextComponentBuilder::builder()
                                                ->setText('Temporarily out of stock')
                                                ->setWrap(true)
                                                ->setSize(ComponentFontSize::XXS)
                                                ->setMargin(ComponentMargin::MD)
                                                ->setColor('#ff5551')
                                                ->setFlex(0)
                                        ])
                                )
                                ->setFooter(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setSpacing(ComponentSpacing::SM)
                                        ->setContents([
                                            ButtonComponentBuilder::builder()
                                                ->setStyle(ComponentButtonStyle::PRIMARY)
                                                ->setColor('#aaaaaa')
                                                ->setAction(
                                                    new UriTemplateActionBuilder(
                                                        'Add to Cart',
                                                        'https://example.com'
                                                    )
                                                ),
                                            ButtonComponentBuilder::builder()
                                                ->setAction(
                                                    new UriTemplateActionBuilder(
                                                        'Add to wishlist',
                                                        'https://example.com'
                                                    )
                                                )
                                        ])
                                ),
                            BubbleContainerBuilder::builder()
                                ->setBody(
                                    BoxComponentBuilder::builder()
                                        ->setLayout(ComponentLayout::VERTICAL)
                                        ->setSpacing(ComponentSpacing::SM)
                                        ->setContents([
                                            ButtonComponentBuilder::builder()
                                                ->setFlex(1)
                                                ->setGravity(ComponentGravity::CENTER)
                                                ->setAction(
                                                    new UriTemplateActionBuilder(
                                                        'See more',
                                                        'https://example.com'
                                                    )
                                                )
                                        ])
                                )
                        ])
                )
        );

                //$imageUrl=UrlBuilder::buildUrl($this->req,['static','buttons','1040.jpg']);
                //$imageUrl='/app/static/shuwa-logo.jpg';
                //$carouselTemplateBuilder=new CarouselTemplateBuilder([
                //    new CarouselColumnTemplateBuilder('foo','bar',$imageUrl, [
                //        new UriTemplateActionBuilder('Go to line.me','https://line.me'),
                //        new PostbackTemplateActionBuilder('Buy','action=buy&itemid=123'),
                //    ]),
                //    new CarouselColumnTemplateBuilder('buz','qux',$imageUrl, [
                //        new PostbackTemplateActionBuilder('Add to cart','action=add&itemid=123'),
                //        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                //    ]),
                //]);
                //$templateMessage = new TemplateMessageBuilder('Button alt text', $carouselTemplateBuilder);
                //$this->bot->replyMessage($replyToken, $templateMessage);
error_log("+++++ QA1");
                break;
            case 'qa2':
error_log("----- QA2");
error_log("+++++ QA2");
                break;
            case 'sql':
error_log("----- SQL");
                $stmt=$this->bot->pdo->query("select * from pg_user;");
                $users=$stmt->fetchAll();
                $text="SELECT * FROM PG_USERS;\n"."=>".strval(count($users));
                $this->bot->replyText($replyToken,$text);
error_log("+++++ SQL");
                break;
            case 'liff':
error_log("----- liff");
            $messageTemplate = new TextMessageBuilder('line://app/1611148065-12Ao52Qx');
            $this->bot->pushMessage($this->textMessage->getUserId(),$messageTemplate);
                break;
            case 'unrich':
error_log("----- unrich");
        $userId=$this->textMessage->getUserId();
error_log("===== userId: ".$userId);
        $res=$this->bot->getRichMenuId($userId);
//error_log("     HTTP satus: ".strval($res->getHTTPStatus());
        if ($res->getHTTPStatus()==200) {
            error_log("     HTTP OK (getRichMenuId)");
        }
        $body=$res->getJSONDecodedBody();
        $richMenuId=$body['richMenuId'];
error_log("===== richMenuId: ".$richMenuId);
        $res=$this->bot->unlinkRichMenu($userId);
        if ($res->getHTTPStatus()==200) {
            error_log("     HTTP OK (unlinkRichMenu)");
        }
        $res=$this->bot->deleteRichMenu($richMenuId); 
        if ($res->getHTTPStatus()==200) {
            error_log("     HTTP OK (deleteRichMenu)");
        }
error_log("ooooo Completed");
                break;
            case 'rich':
error_log("----- Create Richmenu");
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
//if ($res->getHTTPStatus()==200) {
//error_log("     HTTP status=200");
//}
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
        $userId=$this->textMessage->getUserId();
error_log("      User Id=".$userId);
error_log("      Richmenu Id=".$richMenuId);
error_log("----- Link Richmene to User");
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
//$res=$this->bot->setDefaultRichMenu($richMenuId);
//if ($res->getHTTPStatus()==200) {
//error_log("     HTTP staus=200");
//} else {
//$val=strval($res->getHTTPStatus());
//error_log("     HTTP status=".$val);
//}
//if ($res->isSucceeded()==true) {
//error_log("     isSucceeded=true");
//}
//if ($res->getJSONDecodedBody()['status']==200) {
//error_log("JSON 200");
//}
error_log("----- Completed");
                break;
            case 'profile':
                $userId = $this->textMessage->getUserId();
                $this->sendProfile($replyToken, $userId);
                break;
            case 'bye':
                if ($this->textMessage->isRoomEvent()) {
                    $this->bot->replyText($replyToken, 'Leaving room');
                    $this->bot->leaveRoom($this->textMessage->getRoomId());
                    break;
                }
                if ($this->textMessage->isGroupEvent()) {
                    $this->bot->replyText($replyToken, 'Leaving group');
                    $this->bot->leaveGroup($this->textMessage->getGroupId());
                    break;
                }
                $this->bot->replyText($replyToken, 'Bot cannot leave from 1:1 chat');
                break;
            case 'confirm':
                $this->bot->replyMessage(
                    $replyToken,
                    new TemplateMessageBuilder(
                        'Confirm alt text',
                        new ConfirmTemplateBuilder('Do it?', [
                            new MessageTemplateActionBuilder('Yes', 'Yes!'),
                            new MessageTemplateActionBuilder('No', 'No!'),
                        ])
                    )
                );
                break;
            case 'buttons':
                $imageUrl = UrlBuilder::buildUrl($this->req, ['static', 'buttons', '1040.jpg']);
                $buttonTemplateBuilder = new ButtonTemplateBuilder(
                    'My button sample',
                    'Hello my button',
                    $imageUrl,
                    [
                        new UriTemplateActionBuilder('Go to line.me', 'https://line.me'),
                        new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                        new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=123'),
                        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                    ]
                );
                $templateMessage = new TemplateMessageBuilder('Button alt text', $buttonTemplateBuilder);
                $this->bot->replyMessage($replyToken, $templateMessage);
                break;
            case 'carousel':
                $imageUrl = UrlBuilder::buildUrl($this->req, ['static', 'buttons', '1040.jpg']);
                $carouselTemplateBuilder = new CarouselTemplateBuilder([
                    new CarouselColumnTemplateBuilder('foo', 'bar', $imageUrl, [
                        new UriTemplateActionBuilder('Go to line.me', 'https://line.me'),
                        new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                    ]),
                    new CarouselColumnTemplateBuilder('buz', 'qux', $imageUrl, [
                        new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=123'),
                        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                    ]),
                ]);
                $templateMessage = new TemplateMessageBuilder('Button alt text', $carouselTemplateBuilder);
                $this->bot->replyMessage($replyToken, $templateMessage);
                break;
            case 'imagemap':
                $richMessageUrl = UrlBuilder::buildUrl($this->req, ['static', 'rich']);
                $imagemapMessageBuilder = new ImagemapMessageBuilder(
                    $richMessageUrl,
                    'This is alt text',
                    new BaseSizeBuilder(1040, 1040),
                    [
                        new ImagemapUriActionBuilder(
                            'https://store.line.me/family/manga/en',
                            new AreaBuilder(0, 0, 520, 520)
                        ),
                        new ImagemapUriActionBuilder(
                            'https://store.line.me/family/music/en',
                            new AreaBuilder(520, 0, 520, 520)
                        ),
                        new ImagemapUriActionBuilder(
                            'https://store.line.me/family/play/en',
                            new AreaBuilder(0, 520, 520, 520)
                        ),
                        new ImagemapMessageActionBuilder(
                            'URANAI!',
                            new AreaBuilder(520, 520, 520, 520)
                        )
                    ]
                );
                $this->bot->replyMessage($replyToken, $imagemapMessageBuilder);
                break;
            case 'restaurant':
                $flexMessageBuilder = FlexSampleRestaurant::get();
                $this->bot->replyMessage($replyToken, $flexMessageBuilder);
                break;
            case 'shopping':
                $flexMessageBuilder = FlexSampleShopping::get();
                $this->bot->replyMessage($replyToken, $flexMessageBuilder);
                break;
            case 'quickReply':
                $postback = new PostbackTemplateActionBuilder('Buy', 'action=quickBuy&itemid=222', 'Buy');
                $datetimePicker = new DatetimePickerTemplateActionBuilder(
                    'Select date',
                    'storeId=12345',
                    'datetime',
                    '2017-12-25t00:00',
                    '2018-01-24t23:59',
                    '2017-12-25t00:00'
                );

                $quickReply = new QuickReplyMessageBuilder([
                    new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
                    new QuickReplyButtonBuilder(new CameraTemplateActionBuilder('Camera')),
                    new QuickReplyButtonBuilder(new CameraRollTemplateActionBuilder('Camera roll')),
                    new QuickReplyButtonBuilder($postback),
                    new QuickReplyButtonBuilder($datetimePicker),
                ]);

                $messageTemplate = new TextMessageBuilder('Text with quickReply buttons', $quickReply);
                $this->bot->replyMessage($replyToken, $messageTemplate);
                break;
            default:
                $this->echoBack($replyToken, $text);
                break;
        }
    }

    /**
     * @param string $replyToken
     * @param string $text
     */
    private function echoBack($replyToken, $text)
    {
        $this->logger->info("Returns echo message $replyToken: $text");
        $this->bot->replyText($replyToken, $text);
    }

    private function sendProfile($replyToken, $userId)
    {
        if (!isset($userId)) {
            $this->bot->replyText($replyToken, "Bot can't use profile API without user ID");
            return;
        }

        $response = $this->bot->getProfile($userId);
        if (!$response->isSucceeded()) {
            $this->bot->replyText($replyToken, $response->getRawBody());
            return;
        }

        $profile = $response->getJSONDecodedBody();
        $this->bot->replyText(
            $replyToken,
            'Display name: ' . $profile['displayName'],
            'Status message: ' . $profile['statusMessage']
        );
    }
}
