<?php

namespace IlBronza\Notes\Http\Middleware;

use IlBronza\CRUD\Middleware\CRUDBasePackageMiddlewareRolesPermissions;

/**
 * Resolves allowed roles for Notes routes from config (notes.defaultRoles / notes.routeRoles).
 */
class NotesMiddlewareRolesPermissions extends CRUDBasePackageMiddlewareRolesPermissions
{
    protected string $configPackageName = 'notes';
}
