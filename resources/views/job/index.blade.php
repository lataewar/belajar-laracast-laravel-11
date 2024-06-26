<x-template>
  <x-slot:heading>
    Jobs Page
  </x-slot:heading>

  <x-button href="/jobs/create" class="mb-5">Create
    new job</x-button>

  <div class="space-y-4">
    @foreach ($jobs as $item)
      <a href="/jobs/{{ $item['id'] }}" class="block px-4 py-6 border border-gray-200">
        <div class="font-bold text-blue-500 text-sm">
          {{ $item->employer->name }}
        </div>
        <div>
          <strong>{{ $item['title'] }}:</strong> Pays {{ $item['salary'] }} per year
        </div>
      </a>
    @endforeach

    <div>
      {{ $jobs->links() }}
    </div>
  </div>
</x-template>
