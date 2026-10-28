<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Controllers\Tasks\TaskEditUpdateController. */
if (class_exists(\IlBronza\Tasks\Http\Controllers\Tasks\TaskEditUpdateController::class))
    class_alias(\IlBronza\Tasks\Http\Controllers\Tasks\TaskEditUpdateController::class, __NAMESPACE__ . '\\TaskEditUpdateController');
