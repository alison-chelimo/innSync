<!DOCTYPE html>
<html lang="en">
<head>
   @include('home.css')
</head>
<body class="main-layout">
   <header>@include('home.header')</header>

   <div class="our_room">
      <div class="container">
         <div class="titlepage text-center">
            <h2>Our Rooms</h2>
            <p>Find the perfect room for your stay</p>
         </div>

         {{-- Filters --}}
         <form method="GET" action="{{ route('rooms.index') }}" class="row" style="margin-bottom:30px;">
            <div class="col-md-2"><input type="date" name="check_in" class="form-control" value="{{ request('check_in') }}" min="{{ date('Y-m-d') }}"></div>
            <div class="col-md-2"><input type="date" name="check_out" class="form-control" value="{{ request('check_out') }}"></div>
            <div class="col-md-2"><input type="number" name="guests" class="form-control" placeholder="Guests" min="1" value="{{ request('guests') }}"></div>
            <div class="col-md-2">
               <select name="type" class="form-control">
                  <option value="">Any type</option>
                  @foreach ($types as $type)
                     <option value="{{ $type }}" @selected(request('type') === $type)>{{ ucfirst($type) }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-md-2"><input type="number" name="max_price" class="form-control" placeholder="Max price" value="{{ request('max_price') }}"></div>
            <div class="col-md-2">
               <button class="btn btn-primary">Search</button>
               <a href="{{ route('rooms.index') }}" class="btn btn-default">Reset</a>
            </div>
         </form>

         @if ($errors->any())
            <div class="alert alert-danger">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
         @endif

         {{-- Room cards --}}
         <div class="row">
            @forelse ($rooms as $room)
               <div class="col-md-4 col-sm-6">
                  <div class="room">
                     <div class="room_img">
                        <figure>
                           <a href="{{ route('rooms.show', array_merge(['room' => $room->slug], request()->only('check_in','check_out','guests'))) }}">
                              <img src="{{ $room->image_url }}" alt="{{ $room->name }}" style="height:250px;width:100%;object-fit:cover;">
                           </a>
                        </figure>
                     </div>
                     <div class="bed_room">
                        <h3>{{ $room->name }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($room->description, 80) }}</p>
                        <p><strong>KES {{ number_format($room->price_per_night) }}</strong> / night &middot; Sleeps {{ $room->capacity }}</p>
                        <a href="{{ route('rooms.show', array_merge(['room' => $room->slug], request()->only('check_in','check_out','guests'))) }}" class="btn btn-primary btn-sm">View &amp; Book</a>
                     </div>
                  </div>
               </div>
            @empty
               <p class="text-center">No rooms match your search. Try different dates or filters.</p>
            @endforelse
         </div>

         <div class="text-center">{{ $rooms->links() }}</div>
      </div>
   </div>

   @include('home.footer')
</body>
</html>