<?php

$prefix = (string) config('notes.routePrefix');

// Comprende anche le azioni aggiunte da IlBronza\CRUD\ResourceRegistrar.
return [
    $prefix . 'notetypes.index' => 'Mostra l’elenco delle tipologie di nota.',
    $prefix . 'notetypes.archived' => 'Richiede l’elenco delle tipologie di nota in archivio; azione non implementata.',
    $prefix . 'notetypes.create' => 'Mostra il modulo per creare una tipologia di nota.',
    $prefix . 'notetypes.createEmpty' => 'Crea una tipologia di nota con i valori predefiniti senza aprire il modulo.',
    $prefix . 'notetypes.store' => 'Salva una nuova tipologia di nota.',
    $prefix . 'notetypes.show' => 'Mostra i dettagli della tipologia di nota.',
    $prefix . 'notetypes.edit' => 'Mostra il modulo di modifica della tipologia di nota.',
    $prefix . 'notetypes.update' => 'Salva le modifiche della tipologia di nota.',
    $prefix . 'notetypes.destroy' => 'Elimina una tipologia di nota.',
    $prefix . 'notetypes.list' => 'Richiede l’elenco delle tipologie di nota eliminate; azione non implementata.',
    $prefix . 'notes.index' => 'Mostra l’elenco delle note.',
    $prefix . 'notes.archived' => 'Mostra l’elenco delle note archiviate.',
    $prefix . 'notes.create' => 'Mostra il modulo per creare una nota.',
    $prefix . 'notes.createEmpty' => 'Crea una nota con i valori predefiniti senza aprire il modulo.',
    $prefix . 'notes.store' => 'Salva una nuova nota.',
    $prefix . 'notes.show' => 'Mostra i dettagli della nota.',
    $prefix . 'notes.edit' => 'Mostra il modulo di modifica della nota.',
    $prefix . 'notes.update' => 'Salva le modifiche della nota.',
    $prefix . 'notes.destroy' => 'Elimina una nota.',
    $prefix . 'notes.list' => 'Richiede l’elenco delle note eliminate; azione non implementata.',
    $prefix . 'notes.archiveBulk' => 'Archivia le note selezionate.',
    $prefix . 'notes.unseen' => 'Mostra le note non ancora lette dall’utente.',
    $prefix . 'notes.seeBulk' => 'Segna come lette le note selezionate.',
    $prefix . 'notes.seen' => 'Segna come letta la nota selezionata.',
    $prefix . 'notes.deleteMedia' => 'Elimina un allegato della nota.',
    $prefix . 'notes.by' => 'Mostra le note associate al record selezionato.',
    $prefix . 'notes.addBy' => 'Mostra il record e le sue relazioni per scegliere a cosa aggiungere una nota.',
    $prefix . 'notes.add' => 'Crea una nota per il record selezionato e apre la modifica.',
    $prefix . 'notes.addFor' => 'Crea una nota per il record selezionato e apre la modifica.',
];
