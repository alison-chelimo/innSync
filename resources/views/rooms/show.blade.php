<!DOCTYPE html>
<html lang="en">
<head>
   @include('home.css')
   <style>
      .booking-page {
         --accent: #c9a227;        /* change this one colour to re-theme the page */
         --accent-dark: #a8851a;
         --text: #2b2b2b;
         --muted: #777;
         --border: #e6e6e6;
         padding: 50px 0 70px;
         background: #f7f7f7;
      }
      .booking-page .back-link {
         display: inline-block;
         margin-bottom: 20px;
         color: var(--muted);
         font-size: 14px;
      }
      .booking-page .back-link:hover { color: var(--accent-dark); text-decoration: none; }

      /* Room details */
      .booking-page .room-photo {
         width: 100%;
         height: 420px;
         object-fit: cover;
         border-radius: 12px;
         box-shadow: 0 6px 24px rgba(0,0,0,.12);
      }
      .booking-page .room-title {
         margin: 25px 0 10px;
         font-size: 32px;
         font-weight: 700;
         color: var(--text);
      }
      .booking-page .chips { margin-bottom: 18px; }
      .booking-page .chip {
         display: inline-block;
         padding: 6px 14px;
         margin: 0 8px 8px 0;
         background: #fff;
         border: 1px solid var(--border);
         border-radius: 50px;
         font-size: 14px;
         color: var(--text);
      }
      .booking-page .chip strong { color: var(--accent-dark); }
      .booking-page .room-desc {
         font-size: 16px;
         line-height: 1.8;
         color: #555;
      }

      /* Booking card */
      .booking-page .book-card {
         position: sticky;
         top: 20px;
         background: #fff;
         border-radius: 12px;
         box-shadow: 0 6px 24px rgba(0,0,0,.10);
         overflow: hidden;
      }
      .booking-page .book-head {
         padding: 22px 26px;
         background: var(--text);
         color: #fff;
      }
      .booking-page .book-head .price { font-size: 28px; font-weight: 700; color: var(--accent); }
      .booking-page .book-head .per { font-size: 14px; opacity: .8; }
      .booking-page .book-body { padding: 26px; }
      .booking-page .book-body label {
         display: block;
         margin-bottom: 6px;
         font-size: 13px;
         font-weight: 600;
         text-transform: uppercase;
         letter-spacing: .5px;
         color: var(--muted);
      }
      .booking-page .book-body .form-control {
         height: 46px;
         border: 1px solid var(--border);
         border-radius: 8px;
         box-shadow: none;
         font-size: 15px;
      }
      .booking-page .book-body .form-control:focus {
         border-color: var(--accent);
         box-shadow: 0 0 0 3px rgba(201,162,39,.2);
      }
      .booking-page .form-group { margin-bottom: 18px; }

      .booking-page .summary {
         display: none;
         margin: 5px 0 20px;
         padding: 14px 16px;
         background: #faf6e8;
         border: 1px dashed var(--accent);
         border-radius: 8px;
         font-size: 15px;
      }
      .booking-page .summary .row-line { display: flex; justify-content: space-between; margin-bottom: 4px; }
      .booking-page .summary .total {
         margin-top: 8px;
         padding-top: 8px;
         border-top: 1px solid #eadfb4;
         font-weight: 700;
         font-size: 17px;
      }

      .booking-page .btn-book {
         display: block;
         width: 100%;
         padding: 14px;
         border: 0;
         border-radius: 8px;
         background: var(--accent);
         color: #fff;
         font-size: 16px;
         font-weight: 700;
         letter-spacing: .5px;
         transition: background .2s, transform .1s;
      }
      .booking-page .btn-book:hover { background: var(--accent-dark); }
      .booking-page .btn-book:active { transform: translateY(1px); }

      .booking-page .login-note { text-align: center; color: var(--muted); }
      .booking-page .login-note a { color: var(--accent-dark); font-weight: 600; }

      .booking-page .alert { border-radius: 8px; font-size: 14px; }

      @media (max-width: 991px) {
         .booking-page .book-card { position: static; margin-top: 30px; }
         .booking-page .room-photo { height: 300px; }
         .booking-page .room-title { font-size: 26px; }
      }
   </style>
</head>
<body class="main-layout">
   <header>@include('home.header')</header>

   <div class="booking-page">
      <div class="container">
         <a href="{{ route('rooms.index') }}" class="back-link">&larr; Back to all rooms</a>

         <div class="row">
            {{-- Room details --}}
            <div class="col-lg-7">
               <img src="{{ $room->image_url }}" alt="{{ $room->name }}" class="room-photo">
               <h1 class="room-title">{{ $room->name }}</h1>

               <div class="chips">
                  <span class="chip">Sleeps <strong>{{ $room->capacity }}</strong></span>
                  <span class="chip"><strong>KES {{ number_format($room->price_per_night) }}</strong> per night</span>
               </div>

               <p class="room-desc">{{ $room->description }}</p>
            </div>

            {{-- Booking card --}}
            <div class="col-lg-5">
               <div class="book-card">
                  <div class="book-head">
                     <span class="price">KES {{ number_format($room->price_per_night) }}</span>
                     <span class="per">/ night</span>
                  </div>

                  <div class="book-body">
                     @if ($errors->any())
                        <div class="alert alert-danger">
                           @foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                        </div>
                     @endif

                     @auth
                        <form method="POST" action="{{ route('bookings.store', $room->slug) }}">
                           @csrf
                           <div class="form-group">
                              <label for="check_in">Check-in</label>
                              <input type="date" id="check_in" name="check_in" class="form-control"
                                     value="{{ old('check_in', request('check_in')) }}" min="{{ date('Y-m-d') }}" required>
                           </div>
                           <div class="form-group">
                              <label for="check_out">Check-out</label>
                              <input type="date" id="check_out" name="check_out" class="form-control"
                                     value="{{ old('check_out', request('check_out')) }}" required>
                           </div>
                           <div class="form-group">
                              <label for="guests">Guests (max {{ $room->capacity }})</label>
                              <input type="number" id="guests" name="guests" class="form-control" min="1"
                                     max="{{ $room->capacity }}" value="{{ old('guests', request('guests', 1)) }}" required>
                           </div>

                           <div class="summary" id="summary">
                              <div class="row-line"><span id="sum-calc"></span><span id="sum-sub"></span></div>
                              <div class="row-line total"><span>Total</span><span id="sum-total"></span></div>
                           </div>

                           <button type="submit" class="btn-book">Confirm booking</button>
                        </form>
                     @else
                        <p class="login-note">
                           Please <a href="{{ route('login') }}">log in</a> or
                           <a href="{{ route('register') }}">register</a> to book this room.
                        </p>
                     @endauth
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   @include('home.footer')

   <script>
      const price = {{ $room->price_per_night }};
      const inEl = document.getElementById('check_in');
      const outEl = document.getElementById('check_out');
      const box = document.getElementById('summary');

      function updateSummary() {
         if (!inEl) return;

         // Check-out can't be on or before check-in
         if (inEl.value) {
            const next = new Date(inEl.value);
            next.setDate(next.getDate() + 1);
            outEl.min = next.toISOString().split('T')[0];
         }

         if (!inEl.value || !outEl.value) { box.style.display = 'none'; return; }

         const nights = Math.round((new Date(outEl.value) - new Date(inEl.value)) / 86400000);
         if (nights < 1) { box.style.display = 'none'; return; }

         const total = (nights * price).toLocaleString();
         document.getElementById('sum-calc').textContent = 'KES ' + price.toLocaleString() + ' x ' + nights + ' night' + (nights > 1 ? 's' : '');
         document.getElementById('sum-sub').textContent = 'KES ' + total;
         document.getElementById('sum-total').textContent = 'KES ' + total;
         box.style.display = 'block';
      }

      if (inEl) {
         inEl.addEventListener('change', updateSummary);
         outEl.addEventListener('change', updateSummary);
         updateSummary();
      }
   </script>
</body>
</html>