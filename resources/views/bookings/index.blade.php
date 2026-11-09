<!DOCTYPE html>
<html lang="en">
<head>
   @include('home.css')
</head>
<body class="main-layout">
   <header>@include('home.header')</header>

   <div class="our_room">
      <div class="container">
         <div class="titlepage text-center"><h2>My Bookings</h2></div>

         @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
         @endif

         <table class="table table-bordered">
            <thead>
               <tr><th>Room</th><th>Check-in</th><th>Check-out</th><th>Guests</th><th>Total</th><th>Status</th></tr>
            </thead>
            <tbody>
               @forelse ($bookings as $b)
                  <tr>
                     <td>{{ $b->room->name }}</td>
                     <td>{{ $b->check_in->format('d M Y') }}</td>
                     <td>{{ $b->check_out->format('d M Y') }}</td>
                     <td>{{ $b->guests }}</td>
                     <td>KES {{ number_format($b->total_price) }}</td>
                     <td>{{ ucfirst($b->status) }}</td>
                  </tr>
               @empty
                  <tr><td colspan="6" class="text-center">You have no bookings yet.</td></tr>
               @endforelse
            </tbody>
         </table>
      </div>
   </div>

   @include('home.footer')
</body>
</html>