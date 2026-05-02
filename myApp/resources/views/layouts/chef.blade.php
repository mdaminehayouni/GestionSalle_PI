<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen">

    @include('chef.sidebar')

    <main class="flex-1 p-6 bg-gray-100">
        @yield('content')
    </main>

</body>