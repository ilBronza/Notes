<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Controllers\Tasks\TaskIndexController. */
if (class_exists(\IlBronza\Tasks\Http\Controllers\Tasks\TaskIndexController::class))
    class_alias(\IlBronza\Tasks\Http\Controllers\Tasks\TaskIndexController::class, __NAMESPACE__ . '\\TaskIndexController');
