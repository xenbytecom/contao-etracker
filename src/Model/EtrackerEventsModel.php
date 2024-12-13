<?php

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2024 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    LGPL-3.0-or-later
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\Model;

use Contao\Model;

/**
 * @property string $event
 * @property string $selector
 * @property string $handler
 * @property string $category
 * @property string $action
 * @property string $type
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
     * Custom event.
     */
    public const EVT_CUSTOM = 99;

    /**
     * Inner text.
     */
    public const OBJ_INNERTEXT = 1;

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
     * Table name.
     *
     * @var string
     */
    protected static $strTable = 'tl_etracker_events';

    public static function getObjectAttribute(int $objId): string
    {
        return match ($objId) {
            self::OBJ_ALT => 'alt',
            self::OBJ_SRC => 'src',
            self::OBJ_HREF => 'href',
            self::OBJ_TITLE => 'title',
            default => 'textContent',
        };
    }
}
