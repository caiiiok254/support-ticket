<?php

namespace App\Mailers;

use App\Ticket;
use App\User;
use dam1r89\PasswordlessAuth\PasswordlessLink;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{
    protected $mailer;
    protected $fromAddress = 'support@supportticket.dev';
    protected $fromName = 'Support Ticket';
    protected $to;
    protected $subject;
    protected $view;
    protected $data = [];
    protected $attachment;
    protected $managerAddress;

    /**
     * AppMailer constructor.
     * @param $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->managerAddress = User::where('is_manager', 1)->first()->email;
    }

    public function sendTicketInformation($user, Ticket $ticket)
    {
        $manager = User::where('is_manager', 1)->first();

        $link = PasswordlessLink::for($manager)->url('tickets/' . $ticket->ticket_id);

        $this->to = $user->email;

        $this->subject = "[Ticket ID: $ticket->ticket_id] $ticket->title";

        $this->view = 'emails.ticket_info';

        $this->data = compact('user', 'ticket', 'link');

        $this->attachment = $ticket->file;

        $this->deliver();

        $this->view = 'emails.ticket_manager_notification';

        $this->to = $this->managerAddress;

        return $this->deliver();
    }

    public function sendTicketComments($ticketOwner, $user, Ticket $ticket, $comment)
    {
        if ($ticket->status === "Answered") {
            $this->to = $ticketOwner->email;
        } else {
            $this->to = $this->managerAddress;
        }

        $manager = User::where('is_manager', 1)->first();

        $link = PasswordlessLink::for($manager)->url('tickets/' . $ticket->ticket_id);

        $this->subject = "RE: $ticket->title (Ticket ID: $ticket->ticket_id)";

        $this->view = 'emails.ticket_comments';

        $this->data = compact('ticketOwner', 'user', 'ticket', 'comment', 'manager', 'link');

        return $this->deliver();
    }
    public function sendTicketStatusNotification($ticketOwner, Ticket $ticket)
    {
        $this->to = $ticketOwner->email;
        $this->subject = "RE: $ticket->title (Ticket ID: $ticket->ticket_id)";
        $this->view = 'emails.ticket_status';
        $this->data = compact('ticketOwner', 'ticket');
        $this->deliver();
        $this->to = $this->managerAddress;
        return $this->deliver();
    }

    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function($message){
            if($this->attachment !== null) {
                $message->attach($this->attachment);
            }
            $message->from($this->fromAddress, $this->fromName)
                ->to($this->to)->subject($this->subject);
        });
    }
}