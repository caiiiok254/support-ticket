<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Mailers\AppMailer;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function postComment(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);

        $comment = Comment::create([
            'ticket_id' => $request->input('ticket_id'),
            'user_id' => Auth::user()->id,
            'comment' => $request->input('comment')
        ]);

        // send mail if the user commenting is not the ticket owner
        if($comment->ticket->user->id !== Auth::user()->id) {
            $comment->ticket->status = "Answered";
            $comment->ticket->save();

            $mailer->sendTicketComments($comment->ticket->user, Auth::user(), $comment->ticket, $comment);
        } elseif ($comment->ticket->status === "Answered") {
            $comment->ticket->status = "Processing";
            $comment->ticket->save();

            $mailer->sendTicketComments($comment->ticket->user, Auth::user(), $comment->ticket, $comment);
        }

        return redirect()->back()->with("status", "Your comment has been submitted.");
    }
}
