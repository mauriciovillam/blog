<?php

namespace App\Data\Collections;

use App\Data\FeedServicePost;
use Spatie\DataTransferObject\DataTransferObjectCollection;

class FeedServicePostCollection extends DataTransferObjectCollection
{
    public function current(): FeedServicePost
    {
        return parent::current();
    }
}
