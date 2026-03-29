<?php

namespace IlBronza\Timings\Http\Middleware;

use IlBronza\CRUD\Middleware\CRUDBasePackageMiddlewareRolesPermissions;

/**
 * Resolves allowed roles for Timings routes from config (timings.defaultRoles / timings.routeRoles).
 */
class TimingsMiddlewareRolesPermissions extends CRUDBasePackageMiddlewareRolesPermissions
{
    protected string $configPackageName = 'timings';
}
