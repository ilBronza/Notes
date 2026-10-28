<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Controllers\Tasks\TaskDestroyController. */
if (class_exists(\IlBronza\Tasks\Http\Controllers\Tasks\TaskDestroyController::class))
    class_alias(\IlBronza\Tasks\Http\Controllers\Tasks\TaskDestroyController::class, __NAMESPACE__ . '\\TaskDestroyController');
