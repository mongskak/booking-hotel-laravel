<x-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">
                <i class="icon-sm" data-feather="home"></i>
                Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('booking.index') }}">
                <i class="icon-sm" data-feather="align-right"></i>
                Booking List</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="icon-sm" data-feather="plus"></i>
            Add New Booking
        </li>
    </x-slot:breadcrumb>
    <x-slot:title>

        {{ $page_meta['title'] }}
    </x-slot:title>
    @if (empty($page_meta))
        <x-message>
            <x-slot:type>danger</x-slot:type>
            <x-slot:message>{{ $page_meta['message'] }}</x-slot:message>
        </x-message>
    @endif
    <div class="row">
        <div class="card col">
            <div class="card-body">
                <form action="{{ $page_meta['url'] }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="guest_lastname" class="form-label">Guest Last Name</label>
                        <input type="text" name="guest_lastname" placeholder="e.g Due"
                            class="form-control @error('guest_lastname') is-invalid @enderror" id="guest_lastname"
                            id="guest_lastname" @if ($booking->status != '') disabled @endif
                            value="{{ old('guest_lastname', $booking->guest_lastname) }}">
                        @error('guest_lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="guest_firstname" class="form-label">Guest First Name</label>
                        <input type="text" name="guest_firstname" placeholder="e.g John"
                            class="form-control @error('guest_firstname') is-invalid @enderror" id="guest_firstname"
                            id="guest_firstname" @if ($booking->status != '') disabled @endif
                            value="{{ old('guest_firstname', $booking->guest_firstname) }}">
                        @error('guest_firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="check_in_date" class="form-label">Check-In Date</label>
                            <input type="date" name="check_in_date"
                                class="form-control @error('check_in_date') is-invalid @enderror" id="check_in_date"
                                id="check_in_date" @if ($booking->status != '') disabled @endif
                                value="{{ old('check_in_date', $booking->check_in_date) }}">
                            @error('check_in_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-6">
                            <label for="check_out_date" class="form-label">Check-Out Date</label>
                            <input type="date" name="check_out_date"
                                class="form-control @error('check_out_date') is-invalid @enderror" id="check_out_date"
                                id="check_out_date" @if ($booking->status != '') disabled @endif
                                value="{{ old('check_out_date', $booking->check_out_date) }}">
                            @error('check_out_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="adult_capacity" class="form-label">Adult Capacity</label>
                            <input type="number" name="adult_capacity"
                                class="form-control @error('adult_capacity') is-invalid @enderror" id="adult_capacity"
                                id="adult_capacity" @if ($booking->status != '') disabled @endif
                                value="{{ old('adult_capacity', $booking->adult_capacity) }}">
                            @error('adult_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-6">
                            <label for="children_capacity" class="form-label">Children Capacity</label>
                            <input type="number" name="children_capacity"
                                class="form-control @error('children_capacity') is-invalid @enderror"
                                id="children_capacity" id="children_capacity"
                                @if ($booking->status != '') disabled @endif
                                value="{{ old('children_capacity', $booking->children_capacity) }}">
                            @error('children_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="room_number" class="form-label">Room Number</label>
                        <input type="number" name="room_number"
                            class="form-control @error('room_id') is-invalid @enderror" id="room_number" disabled
                            id="room_id"
                            value="{{ $booking->room->roomNumber ?? ($availableRooms->room_number ?? '') }}">

                        <input type="hidden" name="room_id" class="form-control" id="room_id"
                            value="{{ $booking->room->id ?? ($availableRooms->room_id ?? '') }}">
                        <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="row mt-3">
                        <div class="w-auto">
                            <a href="{{ route('booking.index') }}" class="btn btn-outline-primary">
                                <i data-feather="arrow-left" class="icon-sm"></i>
                                Back
                            </a>
                        </div>
                        <div class="col-9">
                            @if ($booking->status == '')
                                <div class="w-50">
                                    @if (isset($availableRooms))
                                        <button class="btn btn-primary" type="submit">
                                            <i data-feather="book" class="icon-sm"></i>
                                            Booked
                                        </button>
                                    @else
                                        <button class="btn btn-primary" type="submit">
                                            <i data-feather="search" class="icon-sm"></i>
                                            Find Available Room
                                        </button>
                                    @endif
                                </div>
                            @endif
                </form>
                @if ($booking->status == 'booked')
                    <div class="gap-3 d-flex">
                        <form
                            action="{{ route('booking.setStatus', ['status' => 'checked_in', 'id' => $booking->id]) }}"
                            method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-success">
                                <i data-feather="log-in" class="icon-sm"></i>
                                Check In</button>
                        </form>
                        <form
                            action="{{ route('booking.setStatus', ['status' => 'cancelled', 'id' => $booking->id]) }}"
                            method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-secondary">
                                <i data-feather="x" class="icon-sm"></i>
                                Canceled</button>
                        </form>
                    </div>
                @endif
                @if ($booking->status == 'checked_in')
                    <div class="w-50">
                        <form
                            action="{{ route('booking.setStatus', ['status' => 'checked_out', 'id' => $booking->id]) }}"
                            method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger">
                                <i data-feather="log-out" class="icon-sm"></i>
                                Check Out</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
    <div class="col text-center">
        <img class="w-75" src="{{ asset('img/vector2.png') }}" alt="">
    </div>
    </div>
</x-layout>
