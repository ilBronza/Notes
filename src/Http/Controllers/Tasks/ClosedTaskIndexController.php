<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Controllers\Tasks\ClosedTaskIndexController. */
if (class_exists(\IlBronza\Tasks\Http\Controllers\Tasks\ClosedTaskIndexController::class))
    class_alias(\IlBronza\Tasks\Http\Controllers\Tasks\ClosedTaskIndexController::class, __NAMESPACE__ . '\\ClosedTaskIndexController');
