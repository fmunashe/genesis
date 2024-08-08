<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Event QR Codes</title>
    <style>
        hr.dotted {
            border: none;
            border-top: 1px dotted black;
            color: #000;
            background-color: #fff;
            height: 1px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Creates 2 equal columns */
            gap: 5px; /* Space between columns */
        }

        .grid-item {
            padding: 2px; /* Adjust padding as needed */
            box-sizing: border-box;
        }
    </style>
</head>

<body>
<h2>Event Ticket Data</h2>
@foreach($codes as $code)
    <div class="grid-container">
        <div class="grid-item">
            <img src="data:image/png;base64,{{ $code }}" alt="QR Code">
        </div>
        <div class="grid-item">
            <p>Event Name: {{$ticket->eventName}}</p>
            <p>Event Venue:{{$ticket->eventVenue}}</p>
            <p>Event Date: {{$ticket->eventDate}}</p>
            <p>Event Start Time:{{\Carbon\Carbon::parse($ticket->startTime)->format('H:s a')}}</p>
            <p>Event End Time:{{\Carbon\Carbon::parse($ticket->endTime)->format('H:s a')}}</p>
        </div>
    </div>
    <hr class="dotted"/>
@endforeach
</body>
</html>
