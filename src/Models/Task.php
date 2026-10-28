<?php

namespace IlBronza\Notes\Models;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Models\Task. */
if (class_exists(\IlBronza\Tasks\Models\Task::class))
    class_alias(\IlBronza\Tasks\Models\Task::class, __NAMESPACE__ . '\\Task');
