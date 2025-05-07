<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="flex justify-center items-center h-screen">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <a href="{{ route('layouts/main') }}" class="text-4xl font-bold text-blue-800">Kumov</a>
            </div>
            <div class="bg-white shadow-xl rounded-lg">
                <div class="p-8">
                    <h2 class="text-2xl font-semibold mb-4 text-center">Register</h2>
                    <form action="{{ route('register-proses') }}" method="post">
                        @csrf
                        <div class="space-y-4">
                            <input type="username" id="username" name="username"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500"
                                placeholder="User Name" autocomplete="off">
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Email address" autocomplete="off">
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Password" autocomplete="off">
                            <button
                                class="w-full bg-green-600 text-white py-3 rounded-lg shadow-lg hover:bg-green-700 transition duration-300">Sign
                                Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>

</html>
