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
            'icon' => 'clipboard',
            'text' => 'notes::notes.manage'
        ]);

        $button->addChild($notesButton);

        $notesButton->addChild(
            $menu->createButton([
                'name' => 'notes.unseen',
                'icon' => 'eye',
                'href' => static::route('notes.unseen'),
                'text' => 'notes::notes.unseen'
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

        $notesButton->addChild(
            $menu->createButton([
                'name' => 'notes.archived',
                'icon' => 'archive',
                'href' => static::route('notes.archived'),
                'text' => 'notes::notes.archived'
            ])
        );

        $notesButton->addChild(
            $menu->createButton([
                'name' => 'notes.manageTypes',
                'icon' => 'gear',
                'href' => static::route('notetypes.index'),
                'text' => 'notes::notes.manageTypes'
            ])
        );

    }
}