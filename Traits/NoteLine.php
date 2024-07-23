<?php

namespace App\Uyumsoft\Traits;

trait NoteLine
{
    private array $NoteLines;

    public function setNoteLines(array $NoteLines): self
    {
        $this->NoteLines = $NoteLines;
        return $this;
    }

    public function getNoteLines(): array
    {
        return $this->NoteLines;
    }

    public function addNoteLine(string $note)
    {
        $this->NoteLines[] = [
            "value" => $note
        ];
    }

    public function addNoteLines(array $notes)
    {
        foreach ($notes as $note) {
            $this->addNoteLine($note);
        }
    }
}
