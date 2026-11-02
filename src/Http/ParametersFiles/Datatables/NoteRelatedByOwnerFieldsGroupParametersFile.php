<?php

namespace IlBronza\Notes\Http\ParametersFiles\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class NoteRelatedByOwnerFieldsGroupParametersFile extends FieldsGroupParametersFile
{
    static function getFieldsGroup() : array
    {
        return [
            'translationPrefix' => 'notes::fields',
            'fields' => [
                'created_at' => [
                    'type' => 'dates.datetime',
                    'order' => [
                        'priority' => 10,
                        'type' => 'DESC',
                    ],
                ],
                'mySelfSee' => 'links.see',
                'user_id' => 'users.name',
                'notes' => [
                    'type' => 'flat',
                    'width' => '650px',
                ],
                'slack' => 'boolean',
                'type_slug' => 'flat',
                'mySelfArchive' => 'links.archive',
                'mySelfDelete' => 'links.delete',
            ],
        ];
    }
}
