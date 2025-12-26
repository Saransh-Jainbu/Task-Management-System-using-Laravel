@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create New Task</h1>
        <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium flex items-center transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Task Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('title') border-red-500 @else border-gray-300 @enderror" value="{{ old('title') }}" placeholder="What needs to be done?">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Add some details...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">Priority</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="priority" value="low" class="peer sr-only" {{ old('priority') == 'low' ? 'checked' : '' }}>
                        <div class="rounded-lg border border-gray-200 p-3 text-center peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 hover:bg-gray-50 transition">
                            <span class="block text-sm font-medium">Low</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="priority" value="medium" class="peer sr-only" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                        <div class="rounded-lg border border-gray-200 p-3 text-center peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:text-yellow-700 hover:bg-gray-50 transition">
                            <span class="block text-sm font-medium">Medium</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="priority" value="high" class="peer sr-only" {{ old('priority') == 'high' ? 'checked' : '' }}>
                        <div class="rounded-lg border border-gray-200 p-3 text-center peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 hover:bg-gray-50 transition">
                            <span class="block text-sm font-medium">High</span>
                        </div>
                    </label>
                </div>
                @error('priority')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-lg shadow-indigo-500/30 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Task
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
