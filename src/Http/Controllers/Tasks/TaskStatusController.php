<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Controllers\Tasks\TaskStatusController. */
if (class_exists(\IlBronza\Tasks\Http\Controllers\Tasks\TaskStatusController::class))
    class_alias(\IlBronza\Tasks\Http\Controllers\Tasks\TaskStatusController::class, __NAMESPACE__ . '\\TaskStatusController');
