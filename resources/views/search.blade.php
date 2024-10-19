<!DOCTYPE html>
<html lang="en" class="h-full bg-cyan-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Check Vaccination Status</title>
    @vite('resources/css/app.css')
    <style>
        /* Similar styles as before can be included here */
        .form-container {
            background-color: white;
            padding: 2rem;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            width: 100%;
            max-width: 400px;
            margin: auto; /* Center the form */
        }
    </style>
</head>
<body>
<div class="form-container fade-in">
    <h1 class="text-center mb-6">Check Vaccination Status</h1>
    <form action="{{ route('check.status') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="nid" class="block text-gray-700 font-medium mb-1">National ID</label>
            <input type="text" name="nid" id="nid" class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your National ID" required>
        </div>
        <div class="text-center">
            <button type="submit" class="bg-blue-500 text-black px-6 py-2 mt-4 rounded-md hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Check Status</button>
        </div>
    </form>

    @if (session('status'))
        <div class="mb-4 text-red-600">
            @if (session('status') == 'Not registered')
                <h2 class="text-xl">Status: {{ session('status') }}</h2>
                <a href="{{ route('register') }}" class="text-blue-500 underline">Register Here</a>
            @else
                <h2 class="text-xl">Status: {{ session('status') }}</h2>
                @if(isset($date))
                    <p>Scheduled Date: {{ $date }}</p>
                @endif
            @endif
        </div>
    @endif

</div>
</body>
</html>
