<?php
$tax = round( $booking->price  * 12/112 ,2 )
?>

@component('mail::message')
# Hey {{ $booking->user->name }} ,

You have requested to cancel your booking on {{ $booking->room->accommodation->title }} - {{ $booking->room->room_type }} on  {{ $booking->created_at->toFormattedDateString() }} .You will see the booking details below 

@component('mail::table')
| Accomodation Details      |  Price  |
| ------------- |:---------:|
| {{ $booking->room->accommodation->title }} - {{ $booking->room->room_type }}       |  {{ $booking->price - $tax }}     |
| Tax (12%)      |  {{ round( $booking->price  * 12/112 ,2 ) }} |
| Total      |  {{ $booking->price }} |
@endcomponent

@component('mail::panel')
Chech In = {{ $booking->checkin }}	
Checkout = {{ $booking->checkout }}	
Email: {{ $booking->email }}	
Contact: {{ $booking->user->phone }}
@endcomponent 


@component('mail::button', ['url' => 'localescapemaldives.com/home/bookings'])
View Booking
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
