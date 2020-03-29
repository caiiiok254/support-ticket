<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Support Ticket Information</title>
</head>
<body>
<p>
User: {{ ucfirst($user->name) }} created a ticket right now.
</p>

<p>Title: {{ $ticket->title }}</p>
<p>Priority: {{ $ticket->priority }}</p>
<p>Status: {{ $ticket->status }}</p>

<p>
    Quick ticket link: {{$link}}
</p>

</body>
</html>
