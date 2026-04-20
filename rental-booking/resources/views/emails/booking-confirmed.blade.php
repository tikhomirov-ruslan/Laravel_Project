<h1>Booking Confirmed</h1>
<p>Hello, {{ $booking->user->name }}.</p>
<p>Your booking for "{{ $booking->property->title }}" has been confirmed.</p>
<p>Dates: {{ $booking->start_date->toDateString() }} to {{ $booking->end_date->toDateString() }}</p>
<p>Total price: ${{ number_format((float) $booking->total_price, 2) }}</p>
