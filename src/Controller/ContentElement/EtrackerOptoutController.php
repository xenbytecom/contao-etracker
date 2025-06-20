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

namespace Xenbyte\ContaoEtracker\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'miscellaneous', template: 'ce_etracker_optout')]
class EtrackerOptoutController extends AbstractContentElementController
{
    public const TYPE = 'etracker_optout';

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if ('checkbox' === $model->etrackerOptOutType) {
            $GLOBALS['TL_BODY'][] = '<script src="bundles/contaoetracker/optout.js"></script>';
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
