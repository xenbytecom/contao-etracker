<?php

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\PageModel;

/**
 * Removes etracker fields on page settings if etracker is disabled at root level
 */
#[AsCallback(table: 'tl_page', target: 'config.onload')]
class PageFieldsOnloadCallback
{
    public function __invoke(DataContainer|null $dc = null): void
    {
        if (null !== $dc) {
            $page = PageModel::findById($dc->id);
            $rootPage = $this->getRootPage((int) $dc->id);
            $enabled = false;
            if ($page instanceof PageModel && $rootPage instanceof PageModel) {
                $enabled = (bool) $rootPage->etrackerEnable;
            }

            if (
                !$enabled && \in_array($page?->type, ['error_401', 'error_403', 'error_404', 'error_503', 'regular'], true)
            ) {
                unset($GLOBALS['TL_DCA']['tl_page']['fields']['etrackerPagename'], $GLOBALS['TL_DCA']['tl_page']['fields']['etrackerAreaname'], $GLOBALS['TL_DCA']['tl_page']['fields']['etrackerAreas']);
            }
        }
    }

    /**
     * Gets the root page of the current page
     *
     * @param int $pid
     * @return PageModel|null
     */
    private function getRootPage(int $pid): PageModel|null
    {
        $parentPages = PageModel::findParentsById($pid);

        foreach ($parentPages as $parent) {
            if ('root' === $parent->type) {
                return $parent;
            }
        }

        return null;
    }
}
