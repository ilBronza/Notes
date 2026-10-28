<?php

namespace IlBronza\Notes\Contracts;

use IlBronza\AccountManager\Models\User;
use IlBronza\Notes\Models\Note;

/** A note subject can refine the standard note permissions. */
interface AuthorizesNotes
{
    public function userCanSeeNote(Note $note, ?User $user, bool $defaultAllowed): bool;
    public function userCanUpdateNote(Note $note, ?User $user, bool $defaultAllowed): bool;
    public function userCanDeleteNote(Note $note, ?User $user, bool $defaultAllowed): bool;
}
