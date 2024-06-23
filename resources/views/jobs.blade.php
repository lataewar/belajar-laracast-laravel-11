<x-template>
  <x-slot:heading>
    Jobs Page
  </x-slot:heading>

  <ul>
    @foreach ($jobs as $item)
      <li>
        <a href="/jobs/{{ $item['id'] }}" class="text-blue-500 hover:underline">
          <strong>{{ $item['title'] }}:</strong> Pays {{ $item['salary'] }} per year
        </a>
      </li>
    @endforeach
  </ul>
</x-template>
