@extends('layouts.app')

@section('content')
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <nav class="navbar navbar-inverse">
                    <a class="navbar-brand" href="#">Welcome {{ Auth::user()->name }}</a>
                        <ul class="nav navbar-nav navbar-right">
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li><a href="{{ url('/home') }}">Customer Dashboard</a></li>
                                    <li><a class="active" href="{{ url('/home/bookings') }}">All Bookings</a></li>
                                    <li><a href="{{ url('/home/inquiries') }}">All Inquiries</a></li>
                                    <li><a href="{{ url('/home/settings') }}">Settings</a></li>
                                </ul>
                            </div>
                        </ul>
                 </nav>
                 <div class="panel-body">
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            
                            @endif
                        @endforeach
                    </div>
                    <table id="taxi" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>                            
                                <th>Accomodation Booked</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->room->accommodation->title }} - {{ $booking->room->room_type }}</td>
                                <td>{{ $booking->checkin }}</td>
                                <td>{{ $booking->checkout }}</td>
                                <td>{{ $booking->created_at->toFormattedDateString() }}</td>
                                @if ($booking->booking_confirmed == 1)
                                    <td>
                                        <button class="btn btn-success disabled">Confirmed</button>
                                    </td>
                                    <td>
                                        <a style="margin:1px" class="btn btn-warning" href="{{ url()->current() }}/cancel/{{ $booking->id }}">Delete Request</a>
                                    </td>
                                @endif
                                
                                @if ($booking->booking_not_available == 1)
                                    <td>
                                        <button class="btn btn-danger disabled">Booking Not Available</button>
                                    </td>
                                    <td>
                                        <a style="margin:1px" class="btn btn-warning" href="">Book again</a>
                                    </td>
                                @endif
                                
                                @if ($booking->booking_requested == 1)
                                    <td>
                                        <button class="btn btn-primary disabled">Booking Requested</button>
                                    </td>
                                    <td>
                                        <a style="margin:1px" class="btn btn-warning" href="{{ url()->current() }}/cancel/{{ $booking->id }}">Delete Request</a>
                                    </td>
                                @endif
                                
                                @if ($booking->booking_cancellation_requested == 1)
                                    <td>                                        
                                        <button class="btn btn-info disabled">Booking Cancellation Requested</button>
                                    </td>
                                    <td>
                                        <a style="margin:1px" class="btn btn-warning" href="">Book again</a>
                                    </td>
                                @endif
                                
                                @if ($booking->booking_cancelled == 1)
                                    <td>
                                        <button class="btn btn-danger disabled">Booking Cancelled</button>
                                    </td>
                                    <td>
                                        <a style="margin:1px" class="btn btn-warning" href="">Book again</a>
                                    </td>
                                @endif
                            </tr>                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
