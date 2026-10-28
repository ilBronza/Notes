<?php

namespace IlBronza\Notes\Http\ParametersFiles\Fieldsets;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\ParametersFiles\Fieldsets\TaskShowFieldsetsParameters. */
if (class_exists(\IlBronza\Tasks\Http\ParametersFiles\Fieldsets\TaskShowFieldsetsParameters::class))
    class_alias(\IlBronza\Tasks\Http\ParametersFiles\Fieldsets\TaskShowFieldsetsParameters::class, __NAMESPACE__ . '\\TaskShowFieldsetsParameters');
