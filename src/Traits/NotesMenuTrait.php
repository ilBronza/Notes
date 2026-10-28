<?php

namespace IlBronza\Notes\Traits;

use function route;

trait NotesMenuTrait
{
	/** @deprecated Use app('tasks')->tasksMenu(). */
	public function tasksMenu($menu, $settingsButton)
	{
		if (app()->bound('tasks'))
			app('tasks')->tasksMenu($menu, $settingsButton);
	}

    public function manageMenuButtons()
    {
        if(! $menu = app('menu'))
            return;

        $settingsButton = $menu->provideButton([
                'text' => 'menu::menu.settings',
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

		if (app()->bound('tasks'))
			app('tasks')->manageMenuButtons();

    }
}
