<div class="our_room">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Our Room</h2>
               <p>Comfortable rooms for every kind of stay</p>
            </div>
         </div>
      </div>
      <div class="row">
         @forelse ($rooms as $room)
            <div class="col-md-4 col-sm-6">
               <div class="room">
                  <div class="room_img">
                     <figure>
                        <a href="{{ route('rooms.show', $room->slug) }}">
                           <img src="{{ $room->image_url }}" alt="{{ $room->name }}" style="height:250px;width:100%;object-fit:cover;"/>
                        </a>
                     </figure>
                  </div>
                  <div class="bed_room">
                     <h3>{{ $room->name }}</h3>
                     <p>{{ \Illuminate\Support\Str::limit($room->description, 80) }}</p>
                     <p><strong>KES {{ number_format($room->price_per_night) }}</strong> / night</p>
                     <a href="{{ route('rooms.show', $room->slug) }}" class="btn btn-primary btn-sm">View &amp; Book</a>
                  </div>
               </div>
            </div>
         @empty
            <p class="text-center">No rooms available right now.</p>
         @endforelse
      </div>
   </div>
</div>