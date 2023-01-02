<?php

namespace App\Services\Contracts;

interface BluePagesServiceInterface
{
    public function cleanupNotesid($notesId = '');

    public function getDetailsFromIntranetId($intranetId = '');

    public function getDetailsFromNotesId($notesId = '');

    public function getNotesidFromIntranetId($intranetId = '');
    public function validateNotesId($notesId = '');

    public function getIntranetIdFromNotesId($notesId = '');
    public function validateIntranetId($intranetId = '');
    public function processDetails($ch);
}
