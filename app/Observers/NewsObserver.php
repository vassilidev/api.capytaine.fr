<?php

namespace App\Observers;

use App\Models\News;

class NewsObserver
{
    public function creating(News $news): void
    {
        $news->title = extractContentFromHtml($news->title);
        $news->description = extractContentFromHtml($news->description);
    }

    public function updating(News $news): void
    {
        $news->title = extractContentFromHtml($news->title);
        $news->description = extractContentFromHtml($news->description);
    }
}
