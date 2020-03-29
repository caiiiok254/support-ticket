@extends('layouts.app')

@section('title', $ticket->title)

@section('content')


    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="ticket-info">
                        <p>{{ $ticket->message }}</p>
                        <p>Category: {{ $ticket->category->name }}</p>
                        <p>
                            @if ($ticket->status === 'Open')
                                Status: <span class="label label-success">{{ $ticket->status }}</span>
                            @elseif ($ticket->status === 'Processing')
                                Status: <span class="label label-warning">{{ $ticket->status }}</span>
                            @elseif ($ticket->status === 'Answered')
                                <span class="label label-info">{{ $ticket->status }}</span>
                            @else
                                Status: <span class="label label-danger">{{ $ticket->status }}</span>
                            @endif
                        </p>
                        <p>Created on: {{ $ticket->created_at->diffForHumans() }}</p>
                    </div>

                </div>
            </div>
            @if ($ticket->file_attached == true)
            <div>File: <a href="/download/{{$ticket->ticket_id}}" target="_blank">Attached file</a></div>
            <hr>
            @endif
            <div>
                @if ($user->is_manager === 1 AND $ticket->status !== "Processing")
                <form action="{{ url('tickets/' . $ticket->ticket_id . '/processing') }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-warning">Process this ticket</button>
                </form>
                <br>
                @endif
            <form action="{{ url('close_ticket/' . $ticket->ticket_id) }}" method="POST">
                {!! csrf_field() !!}
                <button type="submit" class="btn btn-danger">Close</button>
            </form>
            </div>
            <hr>

            @include('tickets.comments')

            <hr>
            @if ($ticket->status === 'Closed')
                You can't reply in a closed ticket!
            @else
            @include('tickets.reply')
                @endif

        </div>
    </div>


@endsection