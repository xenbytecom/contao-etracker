<?php

declare(strict_types=1);

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2025 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xenbyte\ContaoEtracker\Model;

use Contao\Model;

/**
 * @property int    $event
 * @property string $selector
 * @property string $handler
 * @property string $category
 * @property string $action
 * @property string $type
 * @property int    $object
 * @property string $object_text
 * @property string $target_modules
 */
class EtrackerEventsModel extends Model
{
    /**
     * Mail link click.
     */
    public const EVT_MAIL = 1;

    /**
     * Phone number link click.
     */
    public const EVT_PHONE = 2;

    /**
     * Galery open.
     */
    public const EVT_GALLERY = 3;

    /**
     * File download.
     */
    public const EVT_DOWNLOAD = 4;

    /**
     * Collapse accordion element.
     */
    public const EVT_ACCORDION = 5;

    /**
     * Change language element.
     */
    public const EVT_LANGUAGE = 6;

    /**
     * Successful login.
     */
    public const EVT_LOGIN_SUCCESS = 7;

    /**
     * Failed login attempt.
     */
    public const EVT_LOGIN_FAILURE = 8;

    /**
     * User logout.
     */
    public const EVT_LOGOUT = 9;

    /**
     * Registration of a new user.
     */
    public const EVT_USER_REGISTRATION = 10;

    /**
     * Custom event.
     */
    public const EVT_CUSTOM = 99;

    /**
     * textContent of the element.
     */
    public const OBJ_TEXTCONTENT = 1;

    /**
     * alt-Attribute of image.
     */
    public const OBJ_ALT = 2;

    /**
     * Filename.
     */
    public const OBJ_SRC = 3;

    /**
     * href-Attribute of links.
     */
    public const OBJ_HREF = 4;

    /**
     * title-Attribute.
     */
    public const OBJ_TITLE = 5;

    /**
     * title of the module.
     */
    public const OBJ_MODULE_NAME = 6;

    /**
     * custom text content.
     */
    public const OBJ_CUSTOM_TEXT = 7;

    /**
     * textContent or href-Attribute fallback.
     */
    public const OBJ_TEXT_HREF_FALLBACK = 8;

    /**
     * innerText (similar to textContent but excludes HTML tags).
     */
    public const OBJ_INNERTEXT = 9;

    /**
     * textContent or hreflang-Attribute fallback (for language links).
     */
    public const OBJ_TEXT_HREFLANG_FALLBACK = 10;

    /**
     * textContent of an accordion element (without child elements).
     */
    public const OBJ_TEXT_WIHOUT_CHILDS = 11;

    /**
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_etracker_event';

    public static function getObjectAttribute(int $objId): string
    {
        return match ($objId) {
            self::OBJ_ALT => 'evt.target.alt.trim()',
            self::OBJ_SRC => 'evt.target.src.trim()',
            self::OBJ_HREF => 'evt.target.href.trim()',
            self::OBJ_TITLE => 'evt.target.title.trim()',
            self::OBJ_TEXT_HREF_FALLBACK => 'evt.target.textContent.trim() || evt.target.href.trim()',
            self::OBJ_INNERTEXT => 'evt.target.innerText.trim()',
            self::OBJ_TEXT_HREFLANG_FALLBACK => 'evt.target.textContent.trim() || evt.target.hreflang.trim()',
            self::OBJ_TEXT_WIHOUT_CHILDS => "[].reduce.call(evt.target.childNodes, function(a, b) { return a + (b.nodeType === 3 ? b.textContent : ''); }, '').trim()",
            default => 'evt.target.textContent.trim()', // inluding self::OBJ_TEXTCONTENT
        };
    }
}
