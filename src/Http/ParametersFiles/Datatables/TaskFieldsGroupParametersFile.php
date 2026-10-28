<?php

namespace IlBronza\Notes\Http\ParametersFiles\Datatables;

/** @deprecated Install ilbronza/tasks and use \IlBronza\Tasks\Http\ParametersFiles\Datatables\TaskFieldsGroupParametersFile. */
if (class_exists(\IlBronza\Tasks\Http\ParametersFiles\Datatables\TaskFieldsGroupParametersFile::class))
    class_alias(\IlBronza\Tasks\Http\ParametersFiles\Datatables\TaskFieldsGroupParametersFile::class, __NAMESPACE__ . '\\TaskFieldsGroupParametersFile');
