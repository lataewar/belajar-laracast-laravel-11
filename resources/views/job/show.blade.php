<x-template>
  <x-slot:heading>
    Job
  </x-slot:heading>

  <h2 class="text-lg font-bold">{{ $job->title }}</h2>
  <p>
    This job pays {{ $job->salary }} per year.
  </p>

  @can('edit', $job)
    <p>
      <x-button href="/jobs/{{ $job->id }}/edit" class="mt-5">
        Edit Job
      </x-button>
    </p>
  @endcan

</x-template>
