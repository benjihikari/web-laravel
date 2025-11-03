<x-forum.layouts.app>
    <div class="flex items-center gap-2 w-full my-8">
        <livewire:heart :heartable='$questions' />

        <div class="w-full">
            <h2 class="text-2xl font-bold md:text-3xl">
                {{ $questions->title }}
            </h2>

            <div class="flex justify-between">
                <p class="text-xs text-gray-500">
                    <span class="font-semibold">{{ $questions->user->name }}</span> |
                    {{ $questions->category->name }} |
                    {{ $questions->created_at->diffForHumans() }}
                </p>

                <div class="flex items-center gap-2">
                    <a href="#" class="text-xs font-semibold hover:underline">
                        Edit
                    </a>
                    
                    <form action="#" onsubmit="return confirm('¿Estás seguro de eliminar esta pregunta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-md bg-red-600 hover:bg-red-500 px-2 py-1 text-xs font-semibold text-white cursor-pointer">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="my-4">
        <p class="text-gray-200">
           {{ $questions->description }}
        </p>
        <livewire:comment :commentable="$questions" />
    </div>
    
    <ul class="space-y-4">
        @foreach ($questions->answers as $answer)
        <li>
            <div class="flex items-st art gap-2">
                <livewire:heart :heartable='$answer' />

                <div>
                    <p class="text-sm text-gray-300">
                        {{ $answer->content }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $answer->user->name }}
                        | {{ $answer->created_at->diffForHumans() }}
                    </p>
                    <livewire:comment :commentable="$answer" />    
                </div>
            </div>  
        </li>  
        @endforeach
    </ul>

    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-2">Tu Respuesta...</h3>

        <form action="{{ route('answers.store', $questions) }}" method="POST">
            @csrf

            <div class="mb-2">
                <textarea name="content" rows="6" class="w-full p-2 border rounded-md text-xs" required></textarea>
                @error('content')<span class="block text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="rounded-md bg-blue-600 hover:bg-blue-500 px-4 py-2 text-white cursor-pointer">
                Enviar Respuesta
            </button>
        </form>
    </div>
</x-forum.layouts.app>
