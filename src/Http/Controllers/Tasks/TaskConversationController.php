<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\Controllers\Tasks\TaskConversationController. */
if (class_exists(\IlBronza\Tasks\Http\Controllers\Tasks\TaskConversationController::class))
    class_alias(\IlBronza\Tasks\Http\Controllers\Tasks\TaskConversationController::class, __NAMESPACE__ . '\\TaskConversationController');
