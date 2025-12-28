<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configure Tailwind to use class-based dark mode
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        discord: {
                            dark: '#000000',      // Pure black background
                            darker: '#0a0a0a',    // Slightly lighter black for cards
                            darkest: '#000000',   // Pure black navbar
                            light: '#1a1a1a',     // Dark gray for borders
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <script>
        // Dark mode initialization (before page loads to prevent flash)
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body
    class="bg-gray-50 dark:bg-discord-dark text-gray-800 dark:text-gray-100 antialiased min-h-screen flex flex-col transition-colors duration-200">

    <nav
        class="bg-white/80 dark:bg-discord-darkest/95 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-discord-light/20 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('tasks.index') }}"
                        class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">
                        TaskFlow
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    @if(!request()->routeIs('tasks.index'))
                        <a href="{{ route('tasks.index') }}"
                            class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white font-medium transition">Dashboard</a>
                    @endif

                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-discord-light focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-discord-light/20 rounded-lg text-sm p-2.5 transition">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <a href="{{ route('tasks.create') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 dark:bg-white dark:hover:bg-gray-200 dark:text-black text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-lg shadow-indigo-500/30 dark:shadow-white/10">
                        + New Task
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center space-x-2">
                    <!-- New Task Button (Always Visible) -->
                    <a href="{{ route('tasks.create') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 dark:bg-white dark:hover:bg-gray-200 dark:text-black text-white px-3 py-2 rounded-lg text-xs font-medium transition">
                        + New
                    </a>

                    <!-- Dark Mode Toggle (Mobile) -->
                    <button id="theme-toggle-mobile" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-discord-light focus:outline-none rounded-lg text-sm p-2 transition">
                        <svg id="theme-toggle-dark-icon-mobile" class="hidden w-5 h-5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon-mobile" class="hidden w-5 h-5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container max-w-4xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script>
            const notyf = new Notyf({
                duration: 4000,
                position: {
                    x: 'right',
                    y: 'top',
                },
            });
            notyf.success("{{ session('success') }}");
        </script>
    @endif

    <footer
        class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-discord-darkest dark:to-discord-darker border-t border-gray-200 dark:border-discord-light/20 mt-auto transition-colors duration-200">
        <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <!-- Left: Branding -->
                <div class="flex items-center space-x-2">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">TaskFlow</span>
                </div>

                <!-- Center: Copyright -->
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} Built with <span class="text-red-500">❤</span> using Laravel 11
                </p>

                <!-- Right: Links -->
                <div class="flex items-center space-x-6">
                    <a href="https://github.com/Saransh-Jainbu/Task-Management-System-using-Laravel" target="_blank"
                        rel="noopener"
                        class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white transition-colors"
                        title="View on GitHub">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="https://github.com/Saransh-Jainbu/Task-Management-System-using-Laravel" target="_blank"
                        rel="noopener"
                        class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-white transition-colors text-sm font-medium">
                        GitHub
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Dark mode toggle functionality
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        const themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');
        const themeToggleDarkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
        const themeToggleLightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');

        // Show correct icon on page load
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleLightIconMobile.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleDarkIconMobile.classList.remove('hidden');
        }

        // Toggle dark mode function
        function toggleDarkMode() {
            // Toggle icons
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');
            themeToggleDarkIconMobile.classList.toggle('hidden');
            themeToggleLightIconMobile.classList.toggle('hidden');

            // Toggle dark mode
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }

        // Desktop toggle
        themeToggleBtn.addEventListener('click', toggleDarkMode);
        // Mobile toggle
        themeToggleBtnMobile.addEventListener('click', toggleDarkMode);

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>

</html>