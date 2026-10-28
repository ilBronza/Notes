<?php

namespace IlBronza\Notes\Http\ParametersFiles\Fieldsets;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\ParametersFiles\Fieldsets\TaskCreateStoreFieldsetsParameters. */
if (class_exists(\IlBronza\Tasks\Http\ParametersFiles\Fieldsets\TaskCreateStoreFieldsetsParameters::class))
    class_alias(\IlBronza\Tasks\Http\ParametersFiles\Fieldsets\TaskCreateStoreFieldsetsParameters::class, __NAMESPACE__ . '\\TaskCreateStoreFieldsetsParameters');
