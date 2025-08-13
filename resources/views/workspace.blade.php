<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Your Workspaces</h3>

        <form method="POST" action="{{ route('workspaces.store') }}" class="mb-6">
          @csrf
          <input
            type="text"
            name="name"
            placeholder="New workspace name"
            required
            class="border rounded px-3 py-2 mr-2 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Create Workspace
          </button>
        </form>

        <ul>
          @forelse ($workspaces as $workspace)
            <li class="mb-4 border p-4 rounded dark:bg-gray-700">
                <h4 class="font-semibold text-gray-900 dark:text-gray-100 flex">
                    {{ $workspace->name }}
                    <form action="{{ route('workspaces.delete', $workspace) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this workspace?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 ml-2" title="Delete Workspace">
                        <i class="fas fa-trash-alt fa-lg"></i>
                    </button>
                    </form>
                </h4>

                <div class="mt-9">
                    <h5 class="font-semibold mb-2 text-gray-800 dark:text-gray-200">Tasks</h5>

                    <ul>
                    @forelse ($workspace->tasks as $task)
                        <li class="mb-2 flex justify-between items-center">
                        <div>
                            <input
                            type="checkbox"
                            onchange="event.target.form.submit()"
                            {{ $task->completed ? 'checked' : '' }}
                            form="task-update-{{ $task->id }}"
                            />
                            <span class="{{ $task->completed ? 'line-through text-gray-500' : '' }} text-gray-900 dark:text-gray-100">
                            {{ $task->title }}
                            </span>
                            <small class="text-gray-600 dark:text-gray-400 ml-2">
                            @if (!$task->completed)
                                {{ $task->deadline->diffForHumans(null, true) }} remaining
                            @else
                                Completed {{ $task->completed_at->diffForHumans() }}
                            @endif
                            </small>
                        </div>

                        <form id="task-update-{{ $task->id }}" method="POST" action="{{ route('tasks.update', $task) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="completed" value="{{ $task->completed ? 0 : 1 }}" />
                        </form>
                        <form method="POST" action="{{ route('tasks.delete', $task) }}"
                            onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="bg-red-600 text-white px-2 py-2 rounded hover:bg-red-700 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 ml-2"
                                    aria-label="Delete Task"
                                    title="Delete Task"
                                    >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </li>

                    @empty
                        <li class="text-gray-600 dark:text-gray-400 italic">No tasks yet.</li>
                    @endforelse
                    </ul>

                    {{-- @if ($user == $workspace->id) --}}
                    <form method="POST" action="{{ route('tasks.store') }}" class="mt-8">
                        @csrf
                        <input type="hidden" name="workspace_id" value="{{ $workspace->id }}" />

                        <div class="mb-4">
                            <label for="title" class="block font-semibold mb-1 text-gray-800 dark:text-gray-200">
                                Add New Task
                            </label>
                            <input
                                id="title"
                                type="text"
                                name="title"
                                placeholder="New task title"
                                required
                                class="border rounded px-3 py-2 w-full dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500"
                            />
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="block font-semibold mb-1 text-gray-800 dark:text-gray-200">
                                Deadline
                            </label>
                            <input
                                id="deadline"
                                type="datetime-local"
                                name="deadline"
                                required
                                class="border rounded px-3 py-2 w-full dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500"
                            />
                        </div>

                        <button
                            type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                            Add Task
                        </button>
                    </form>

                    {{-- @endif --}}
                </div>
            </li>
          @empty
            <li class="text-gray-600 dark:text-gray-400 italic">No workspaces yet.</li>
          @endforelse
        </ul>
      </div>

    </div>
  </div>
</x-app-layout>
