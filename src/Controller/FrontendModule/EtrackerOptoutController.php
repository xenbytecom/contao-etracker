<?php

/*
 * etracker plugin for Contao
 *
 * (c) Xenbyte, Stefan Brauner <info@xenbyte.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\ModuleModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(category: 'miscellaneous', template: 'mod_etracker_optout')]
class EtrackerOptoutController extends AbstractFrontendModuleController
{
    public const TYPE = 'optout';

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        $GLOBALS['TL_BODY'][] = Template::generateScriptTag('bundles/contaoetracker/optout.js');

//        $page = $this->getPageModel();
//        var_dump($page);

        // Get some information about the current page
        $template->{'etracker_tld'} = '';

        return $template->getResponse();
    }
}
