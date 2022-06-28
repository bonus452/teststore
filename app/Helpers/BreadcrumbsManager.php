<?php
namespace App\Helpers;

use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager as DJBreadcrumbsManager;
use DaveJamesMiller\Breadcrumbs\Exceptions\ViewNotSetException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\HtmlString;

class BreadcrumbsManager extends DJBreadcrumbsManager
{
    public function render(string $name = null, ...$params): HtmlString
    {

        $view = Request::is('admin', 'admin/*')
            ? config('breadcrumbs.admin_view')
            : config('breadcrumbs.view');

        if (!$view) {
            throw new ViewNotSetException('Breadcrumbs view not specified (check config/breadcrumbs.php)');
        }

        return $this->view($view, $name, ...$params);
    }
}
