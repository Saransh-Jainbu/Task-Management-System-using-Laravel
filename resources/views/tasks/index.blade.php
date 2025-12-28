@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Your Tasks</h1>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            {{ $tasks->where('is_completed', true)->count() }} / {{ $tasks->count() }} Completed
        </div>
    </div>

    <!-- Priority Filters -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('tasks.index') }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ !request('priority') ? 'bg-indigo-600 text-white dark:bg-white dark:text-black' : 'bg-gray-100 dark:bg-discord-darker text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-discord-light' }}">
            All
        </a>
        <a href="{{ route('tasks.index', ['priority' => 'low']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ request('priority') === 'low' ? 'bg-green-600 text-white' : 'bg-gray-100 dark:bg-discord-darker text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-discord-light' }}">
            Low Priority
        </a>
        <a href="{{ route('tasks.index', ['priority' => 'medium']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ request('priority') === 'medium' ? 'bg-yellow-600 text-white' : 'bg-gray-100 dark:bg-discord-darker text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-discord-light' }}">
            Medium Priority
        </a>
        <a href="{{ route('tasks.index', ['priority' => 'high']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ request('priority') === 'high' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-discord-darker text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-discord-light' }}">
            High Priority
        </a>
    </div>

    @if($tasks->isEmpty())
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
            <div class="w-20 h-20 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No tasks yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first task.</p>
            <a href="{{ route('tasks.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Create Task
            </a>
        </div>
    @else
        <div class="max-h-[60vh] overflow-y-auto space-y-4">
            @foreach($tasks as $task)
                <div
                    class="group bg-white dark:bg-discord-darker rounded-xl shadow-sm border border-gray-100 dark:border-discord-light/20 p-5 hover:shadow-md transition-all duration-200 {{ $task->is_completed ? 'opacity-75 bg-gray-50 dark:bg-discord-darkest' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="mt-1 w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors {{ $task->is_completed ? 'bg-green-500 border-green-500' : 'border-gray-300 hover:border-green-500' }}">
                                    @if($task->is_completed)
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                    @endif
                                </button>
                            </form>

                            <div>
                                <h3
                                    class="text-lg font-semibold {{ $task->is_completed ? 'line-through text-gray-500 dark:text-gray-600' : 'text-gray-900 dark:text-white' }}">
                                    {{ $task->title }}
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm line-clamp-2">{{ $task->description }}</p>

                                <div class="flex items-center mt-3 space-x-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                                                    @if($task->priority == 'high') bg-red-100 text-red-800 
                                                                                    @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800 
                                                                                    @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        Created {{ $task->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('tasks.edit', $task) }}"
                                class="p-2 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection