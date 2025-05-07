<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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
                    <h2 class="text-2xl font-semibold mb-4 text-center">Login</h2>
                    <form action="{{ route('login-proses') }}" method="post">
                        @csrf
                        <div class="space-y-4">
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Email address" autocomplete="off">
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Password" autocomplete="off">
                            <button
                                class="w-full bg-blue-600 text-white py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Sign
                                In</button>
                            <div class="text-center mt-2">
                                <a href="" class="text-blue-600">Forgotten Password?</a>
                            </div>
                        </div>
                        <div class="flex items-center mt-6">
                            <hr class="flex-grow border border-gray-300">
                            <span class="mx-4 text-gray-600 text-sm">or</span>
                            <hr class="flex-grow border border-gray-300">
                        </div>
                        <div class="mt-6 flex justify-center items-center">
                            <a href="{{ route('register') }}"
                                class="w-40 bg-green-500 text-gray-800 py-3 text-center rounded-lg shadow-lg hover:bg-gray-300 transition duration-300">Create
                                New Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
