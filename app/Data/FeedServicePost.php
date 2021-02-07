<?php

namespace App\Data;

use Spatie\DataTransferObject\DataTransferObject;

class FeedServicePost extends DataTransferObject
{
    public string $title;

    public string $description;

    public string $publication_date;
}
