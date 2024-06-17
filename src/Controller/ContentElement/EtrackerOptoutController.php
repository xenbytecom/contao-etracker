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

namespace Xenbyte\ContaoEtracker\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\PageModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'miscellaneous', template: 'ce_etracker_optout')]
class EtrackerOptoutController extends AbstractContentElementController
{
    public const TYPE = 'etracker_optout';

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        if ('checkbox' === $model->etrackerOptOutType) {
            $GLOBALS['TL_BODY'][] = Template::generateScriptTag('bundles/contaoetracker/optout.js');
        }

        $rootpage = PageModel::findById($GLOBALS['objPage']->rootId);
        if ($rootpage instanceof PageModel) {
            $tld = (string) $rootpage->etrackerDomain;
            if ('' === $tld) {
                $tld = $request->getHost();
            }

            $template->etracker_tld = $tld;
            $template->etrackerOptOutType = $model->etrackerOptOutType;
        }

        return $template->getResponse();
    }
}
