<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Controllers\Tasks\TaskCRUD. */
if (class_exists(\IlBronza\Tasks\Http\Controllers\Tasks\TaskCRUD::class))
    class_alias(\IlBronza\Tasks\Http\Controllers\Tasks\TaskCRUD::class, __NAMESPACE__ . '\\TaskCRUD');
