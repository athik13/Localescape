@component('mail::message')
# Hey {{ $booking->user->name }} ,

We have recieved a booking request on {{ $booking->room->accommodation->title }} - {{ $booking->room->room_type }} on  {{ $booking->created_at->toFormattedDateString() }} .You will see the booking details below 

@component('mail::table')
| Accomodation Details      |  Price  |
| ------------- |:---------:|
| Local Escape Boutique - Deluxe Room       |  $1000      |
| Tax (12%)      |  $120  |
| Total      |  $1120  |
@endcomponent

@component('mail::panel')
Chech In = 21.05.20xx	
Checkout = 25.06.20xx	
Email: mailaddress@xxx.com	
Contact: +960 9xxxxxx
@endcomponent
Our Agents will send you a booking confirmation as soon as possible.

@component('mail::button', ['url' => ''])
View Booking
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
