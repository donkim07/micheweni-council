<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use App\Models\NewsletterSubscription;

class NewsletterEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The news items to include in the newsletter.
     *
     * @var \Illuminate\Support\Collection
     */
    public $newsItems;
    
    /**
     * The subscriber information.
     *
     * @var \App\Models\NewsletterSubscription
     */
    public $subscriber;
    
    /**
     * The newsletter subject.
     *
     * @var string
     */
    public $emailSubject;

    /**
     * Create a new message instance.
     *
     * @param  \Illuminate\Support\Collection  $newsItems
     * @param  \App\Models\NewsletterSubscription  $subscriber
     * @param  string  $subject
     * @return void
     */
    public function __construct(Collection $newsItems, NewsletterSubscription $subscriber, $subject = null)
    {
        $this->newsItems = $newsItems;
        $this->subscriber = $subscriber;
        $this->emailSubject = $subject ?? 'Micheweni Waste Portal Newsletter: Latest Updates';
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.newsletter',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
} 