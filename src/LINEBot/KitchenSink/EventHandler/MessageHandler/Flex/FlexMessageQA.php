<?php

/**
 * Copyright 2018 LINE Corporation
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

namespace LINE\LINEBot\KitchenSink\EventHandler\MessageHandler\Flex;

use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\Constant\Flex\ComponentButtonHeight;
use LINE\LINEBot\Constant\Flex\ComponentButtonStyle;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpaceSize;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\Constant\Flex\ComponentGravity;
use LINE\LINEBot\Constant\Flex\ComponentAlign;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\BlockStyleBuilder;
use LINE\LINEBot\MessageBuilder\Flex\BubbleStylesBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpacerComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;

use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;

class FlexMessageQA
{
    /**
     * Create sample restaurant flex message
     *
     * @return \LINE\LINEBot\MessageBuilder\FlexMessageBuilder
     */
    public static function get()
    {
        return FlexMessageBuilder::builder()
            ->setAltText('お問い合わせ')
            ->setContents(
                BubbleContainerBuilder::builder()
                    ->setStyles(self::createStyle())
                    ->setHeader(self::createHeaderBlock())
                    //->setHero(self::createHeroBlock())
                    ->setBody(self::createBodyBlock())
                    //->setFooter(self::createFooterBlock())
            );
    }

    private static function createStyle()
    {
        return BubbleStylesBuilder::builder()
            ->setHeader(BlockStyleBuilder::builder()
                ->setSeparatorColor('#000000')
                ->setSeparator(true))
            ->setHero(null)
            ->setBody(null)
            ->setFooter(null);
    }

    private static function createHeaderBlock()
    {
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setAlign(ComponentAlign::CENTER)
                    ->setGravity(ComponentGravity::CENTER)
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setText('カテゴリーを選択してください')
            ]);
    }

    private static function createHeroBlock()
    {
        return ImageComponentBuilder::builder()
            ->setUrl('https://example.com/cafe.png')
            ->setSize(ComponentImageSize::FULL)
            ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
            ->setAspectMode(ComponentImageAspectMode::COVER)
            ->setAction(new UriTemplateActionBuilder(null, 'https://example.com'));
    }

    private static function createBodyBlock()
    {
        $category1=TextComponentBuilder::builder()
            ->setText('カテゴリー 1')
            ->setSize(ComponentFontSize::LG)
            ->setMargin(ComponentMargin::MD)
            ->setAction(new PostbackTemplateActionBuilder(null,'CATEGORY1'));
        $category2=TextComponentBuilder::builder()
            ->setText('カテゴリー 2')
            ->setSize(ComponentFontSize::LG)
            ->setMargin(ComponentMargin::MD)
            ->setAction(new PostbackTemplateActionBuilder(null,'CATEGORY2'));
        $category3=TextComponentBuilder::builder()
            ->setText('カテゴリー 3')
            ->setSize(ComponentFontSize::LG)
            ->setMargin(ComponentMargin::MD)
            ->setAction(new PostbackTemplateActionBuilder(null,'CATEGORY3'));
        $category4=TextComponentBuilder::builder()
            ->setText('カテゴリー 4')
            ->setSize(ComponentFontSize::LG)
            ->setMargin(ComponentMargin::MD)
            ->setAction(new PostbackTemplateActionBuilder(null,'CATEGORY4'));
        $category5=TextComponentBuilder::builder()
            ->setText('カテゴリー 5')
            ->setSize(ComponentFontSize::LG)
            ->setMargin(ComponentMargin::MD)
            ->setAction(new PostbackTemplateActionBuilder(null,'CATEGORY5'));
        $category6=TextComponentBuilder::builder()
            ->setText('カテゴリー 6')
            ->setSize(ComponentFontSize::LG)
            ->setMargin(ComponentMargin::MD)
            ->setAction(new PostbackTemplateActionBuilder(null,'CATEGORY6'));

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([$category1,$category2,$category3,$category4,$category5,$category6]);
    }

    private static function createFooterBlock()
    {
        return null;
    }
}
