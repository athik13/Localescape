<?php
$tax = round( $booking->price  * 12/112 ,2 )
?>

@component('mail::message')
# Hey {{ $booking->room->accommodation->extranet->name }} ,

You have recieved a booking request on {{ $booking->room->accommodation->title }} - {{ $booking->room->room_type }} on  {{ $booking->created_at->toFormattedDateString() }} .You will see the booking details below 

@component('mail::table')
| Accomodation Details      |  Price  |
| ------------- |:---------:|
| {{ $booking->room->accommodation->title }} - {{ $booking->room->room_type }}       |  {{ $booking->price - $tax }}     |
| Tax (12%)      |  {{ round( $booking->price  * 12/112 ,2 ) }} |
| Total      |  {{ $booking->price }} |
@endcomponent

@component('mail::panel')
Customer Information
Chech In = {{ $booking->checkin }}	
Checkout = {{ $booking->checkout }}	
Email: {{ $booking->email }}	
Contact: {{ $booking->user->phone }}
@endcomponent
Check this Booking from your Extranet panel to either confirm or reject the booking.

@component('mail::button', ['url' => 'localescapemaldives.com/extranet/bookings'])
View Booking
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
