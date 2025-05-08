<?php

namespace IlBronza\Notes\Traits;

trait NotesMenuTrait
{
    public function manageMenuButtons()
    {
        if(! $menu = app('menu'))
            return;

        $settingsButton = $menu->provideButton([
                'text' => 'generals.settings',
                'name' => 'settings',
                'icon' => 'gear',
                'roles' => ['administrator']
            ]);

        $settingsButton->setFirst();

        $notesButton = $menu->createButton([
            'name' => 'notesManager',
            'icon' => 'clipboard',
            'text' => 'notes::notes.manage'
        ]);

        $settingsButton->addChild($notesButton);

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

        $tasksButton = $menu->createButton([
            'name' => 'tasksManager',
            'icon' => 'message',
            'text' => 'notes::tasks.manage'
        ]);

        $settingsButton->addChild($tasksButton);

        $tasksButton->addChild(
            $menu->createButton([
                'name' => 'tasks.index',
                'icon' => 'list',
                // 'href' => static::route('notes.unseen'),
                'href' => route('notesmanagertasks.index'),
                'text' => 'notes::tasks.list'
            ])
        );



    }
}