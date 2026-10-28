<?php

namespace IlBronza\Notes\Http\Middleware;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Middleware\TasksMiddlewareAccess. */
if (class_exists(\IlBronza\Tasks\Http\Middleware\TasksMiddlewareAccess::class))
    class_alias(\IlBronza\Tasks\Http\Middleware\TasksMiddlewareAccess::class, __NAMESPACE__ . '\\TasksMiddlewareAccess');
