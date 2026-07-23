<?php

namespace App\Observers;

use App\Models\Opportunities\CircularEconomy\News;
use App\Http\Controllers\NewsletterController;

class NewsObserver
{
    /**
     * Handle the News "created" event.
     *
     * @param  \App\Models\News  $news
     * @return void
     */
    public function created(News $news)
    {
        // If news is published, send newsletter update
        if ($news->is_published) {
            $this->sendNewsletterUpdate($news);
        }
    }

    /**
     * Handle the News "updated" event.
     *
     * @param  \App\Models\News  $news
     * @return void
     */
    public function updated(News $news)
    {
        // If the news was just published (changed from unpublished to published)
        if ($news->is_published && $news->wasChanged('is_published')) {
            $this->sendNewsletterUpdate($news);
        }
    }

    /**
     * Send newsletter update when news is published
     *
     * @param  \App\Models\News  $news
     * @return void
     */
    private function sendNewsletterUpdate(News $news)
    {
        $newsletterController = app(NewsletterController::class);
        $newsletterController->sendNewsUpdate($news);
    }
} 