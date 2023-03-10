<?php

namespace IlBronza\Notes\Traits;

trait NotesMenuTrait
{
    public function manageMenuButtons()
    {
        if(! $menu = app('menu'))
            return;

        $button = $menu->provideButton([
                'text' => 'generals.settings',
                'name' => 'settings',
                'icon' => 'gear',
                'roles' => ['administrator']
            ]);

        $button->setFirst();

        $notesButton = $menu->createButton([
            'name' => 'notesManager',
            'icon' => 'user-gear',
            'text' => 'notes::notes.manage'
        ]);

        $button->addChild($notesButton);

        $notesButton->addChild(
            $menu->createButton([
                'name' => 'notes.manageTypes',
                'icon' => 'user-gear',
                'href' => static::route('notetypes.index'),
                'text' => 'notes::notes.manageTypes'
            ])
        );

        $notesButton->addChild(
            $menu->createButton([
                'name' => 'notes.index',
                'icon' => 'list',
                'href' => static::route('notes.index'),
                'text' => 'notes::notes.index'
            ])
        );
    }
}