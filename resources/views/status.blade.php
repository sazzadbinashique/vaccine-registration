<!DOCTYPE html>
<html>
<head>
    <title>Vaccination Status</title>
</head>
<body>
<h1>Your Vaccination Status</h1>

@if ($status === 'Not registered')
    <p>Status: {{ $status }}</p>
    <a href="{{ route('register') }}">Register for Vaccination</a>
@else
    <p>Status: {{ $status }}</p>
    @if ($status === 'Scheduled')
        <p>Your scheduled vaccination date: {{ $scheduledDate }}</p>
    @endif
@endif
</body>
</html>
