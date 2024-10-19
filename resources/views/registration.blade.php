<!DOCTYPE html>
<html lang="en" class="h-full bg-cyan-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COVID Vaccine Registration</title>
    @vite('resources/css/app.css')
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ecfeff; /* Tailwind's cyan-50 */
        }
        .fade-in {
            opacity: 0;
            animation: fadeIn ease 1.5s;
            animation-fill-mode: forwards;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .form-container {
            background-color: white;
            padding: 2rem;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            width: 100%;
            max-width: 500px;
        }
        .form-container h1 {
            font-size: 1.75rem;
            font-weight: bold;
            color: #333;
        }
        .form-container input, .form-container select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            transition: border-color 0.3s;
        }
        .form-container input:focus, .form-container select:focus {
            border-color: #60a5fa; /* Tailwind's blue-400 */
            outline: none;
        }
        .form-container label {
            margin-bottom: 0.5rem;
            display: inline-block;
            font-size: 1rem;
            font-weight: 500;
            color: #555;
        }
        .submit-btn {
            background-color: #3b82f6; /* Tailwind's blue-500 */
            color: white;
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 0.375rem;
            width: 100%;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #2563eb; /* Tailwind's blue-600 */
        }
    </style>
</head>
<body>
<div class="form-container fade-in">
    <h1 class="text-center mb-6">Register for Vaccination</h1>
    <form action="{{ route('register') }}" method="POST" class="space-y-5">
        @csrf
        <div class="mt-2">
            <label for="nid" class="block">National ID</label>
            <input type="text" name="nid" id="nid" class="border p-3 w-full" placeholder="Enter your National ID" required>
        </div>
        <div class="mt-2">
            <label for="name" class="block">Name</label>
            <input type="text" name="name" id="name" class="border p-3 w-full" placeholder="Enter your full name" required>
        </div>
        <div class="mt-2">
            <label for="email" class="block">Email</label>
            <input type="email" name="email" id="email" class="border p-3 w-full" placeholder="Enter your email" required>
        </div>
        <div class="mt-2">
            <label for="vaccine_center_id" class="block">Vaccine Center</label>
            <select name="vaccine_center_id" id="vaccine_center_id" class="border p-3 w-full" required>
                <option value="">Select a vaccine center</option>
                @foreach($vaccineCenters as $center)
                    <option value="{{ $center->id }}">{{ $center->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="submit-btn mt-2">Register Now</button>
        </div>
    </form>
</div>
</body>
</html>
