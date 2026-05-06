<div class="p-5">
  <img src="{{ $film->poster }}" class="w-64">
  <h1 class="text-2xl font-bold">{{ $film->judul }}</h1>
  <p>{{ $film->sinopsis }}</p>

  <h2 class="mt-5 font-bold">Jadwal:</h2>
  @foreach($film->jadwal as $j)
    <a href="/booking/{{ $j->id }}" class="bg-blue-500 text-white p-2 block mt-2">
      {{ $j->waktu_tayang }}
    </a>
  @endforeach
</div>