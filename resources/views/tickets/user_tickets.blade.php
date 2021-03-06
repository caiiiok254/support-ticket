@extends('layouts.app')

@section('title', 'My Tickets')

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-ticket"> My Tickets</i>
            </div>

            <div class="panel-body">
                @if($tickets->isEmpty())
                <p>You have not created any tickets.</p>
                @else
                <table class="table">
                    <thead>
                    <tr>
                        <th>@sortablelink('category')</th>
                        <th>@sortablelink('title')</th>
                        <th>@sortablelink('status')</th>
                        <th>@sortablelink('updated_at', 'Last updated')</th>
                        <th style="text-align:center" colspan="2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td>
                            {{ $ticket->category->name }}
                        </td>
                        <td>
                            <a href="{{ url('tickets/' . $ticket->ticket_id) }}">
                                #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                            </a>
                        </td>
                        <td>
                            @if ($ticket->status === 'Open')
                                <span class="label label-success">{{ $ticket->status }}</span>
                            @elseif ($ticket->status === 'Processing')
                                <span class="label label-warning">{{ $ticket->status }}</span>
                            @elseif ($ticket->status === 'Answered')
                                <span class="label label-info">{{ $ticket->status }}</span>
                            @else
                                <span class="label label-danger">{{ $ticket->status }}</span>
                            @endif
                        </td>
                        <td>
                            {{ $ticket->updated_at }}
                        </td>
                        <td>
                            @if($ticket->status === 'Open')
                                <a href="{{ url('tickets/' . $ticket->ticket_id) }}" class="btn btn-primary">Comment</a>

                                <form action="{{ url('/close_ticket/' . $ticket->ticket_id) }}" method="POST">
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-danger">Close</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $tickets->render() }}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection