<?php

namespace IlBronza\Notes\Notifications;

use IlBronza\Notes\Models\Note;
use IlBronza\Notifications\Notification;

class NoteNotification extends Notification
{
    public $hasLink = false;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Note $note)
    {
        $this->note = $note;

        parent::__construct();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => $this->note->getUserId(),
            'type' => $this->note->getTypeSlug(),
            'message' => $this->note->getText()
        ];
    }
}
