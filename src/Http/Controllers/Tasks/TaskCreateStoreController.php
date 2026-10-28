<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Controllers\Tasks\TaskCreateStoreController. */
if (class_exists(\IlBronza\Tasks\Http\Controllers\Tasks\TaskCreateStoreController::class))
    class_alias(\IlBronza\Tasks\Http\Controllers\Tasks\TaskCreateStoreController::class, __NAMESPACE__ . '\\TaskCreateStoreController');
