<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // view index
    public function index()
    {
        $bookings = Booking::latest()->paginate(10);
        return view('pages.booking.index', compact('bookings'));
    }

    // view add booking
    public function new()
    {
        $booking = new Booking();
        $page_meta = [
            'title' => 'Add New Booking',
            'url' => route('booking.available')
        ];
        return view('pages.booking.detail', compact('booking', 'page_meta'));
    }

    // view detail booking
    public function detail($id)
    {
        $booking = Booking::find($id);
        $page_meta = [
            'title' => 'Booking Detail',
            'url' => route('booking.edit', $booking->id)
        ];
        $roomAvailable = [];
        return view('pages.booking.detail', compact('booking', 'page_meta', 'roomAvailable'));
    }



    // action booking update
    public function edit(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->update($request->all());
        return redirect()->route('booking.index')->with('notification', [
            'type' => 'success',
            'message' => 'Booking updated successfully'
        ]);
    }

    public function handleRoomBooking(Request $request)
    {

        $validated = $request->validate([
            'guest_firstname' => 'required|string|max:255',
            'guest_lastname' => 'required|string|max:255',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adult_capacity' => 'required|integer|min:1',
        ]);

        // Jika user memilih room_id, proses booking

        if ($request->filled('room_id')) {
            $this->create($request);
            return redirect()->route('booking.index')->with('notification', [
                'type' => 'success',
                'message' => 'Booking created successfully'
            ]);
        }

        // Jika tidak ada room_id, fetch available rooms
        $availableRooms = Room::getAvailableRooms(
            $request->check_in_date,
            $request->check_out_date,
            $request->adult_capacity,
            $request->children_capacity ?? 0,
        );
        // Lempar exception jika tidak ada kamar yang tersedia
        if (empty($availableRooms)) {
            throw ValidationException::withMessages([
                'availableRooms' => 'No available rooms match your criteria.'
            ]);
        }
        // dd($availableRooms);
        $booking = new Booking($request->all());

        $page_meta = [
            'title' => 'Add New Booking',
            'url' => isset($availableRooms) ? route('booking.create') : route('booking.available')
        ];

        return view('pages.booking.detail', compact('booking', 'page_meta', 'availableRooms'));
    }
    // action booking create
    public function create(Request $request)
    {
        $data = $request->all();

        if (is_null($data['children_capacity'])) {
            $data['children_capacity'] = 0;
        }

        Booking::create($data);
        return redirect()->route('booking.index')->with('notification', [
            'type' => 'success',
            'message' => 'Booking created successfully'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $booking = Booking::find($request->id); // Mencari booking berdasarkan ID
        $booking->update(['status' => $request->status]); // Update hanya status

        if ($request->stay) {
            return redirect()->back()->with('notification', [
                'type' => 'success',
                'message' => 'Booking status updated successfully'
            ]);
        } else {
            return redirect()->route('booking.index')->with('notification', [
                'type' => 'success',
                'message' => 'Booking status updated successfully'
            ]);
        }
    }

    public function search(Request $request)
    {

        // cari booking berdasarkan nama belakang dan status nama belakng bisa dan status bisa kosong
        $bookings = Booking::where('guest_lastname', 'like', '%' . $request->guest_lastname . '%')
            ->where('status', 'like', '%' . $request->status . '%')
            ->latest()->paginate(10);

        $search = [
            'query' => $request->guest_lastname,
            'status' => $request->status,
        ];

        if ($request->stay) {
            return redirect()->back(compact('bookings', 'search'))->with('notification', [
                'type' => 'success',
                // message booking berhasil di temukan
                'message' => 'Booking ' . $search['query'] . ' Found'
            ]);
        } else {
            return view('pages.booking.index', compact('bookings', 'search'));
        }
    }

    public function checked_out_info($id)
    {
        //find booking by id
        $booking = Booking::with('room')->find($id);

        //find room service by booking id
        $roomServices = RoomService::where('booking_id', $id)->with('RoomServiceType')->get();

        $page_meta = [
            'title' => 'Checked Out Information',
            'url' => route('booking.setStatus', ['status' => 'checked_out', 'id' => $booking->id, 'stay' => true])
        ];

        $data = [
            'booking' => $booking,
            'page_meta' => $page_meta,
            'roomService' => $roomServices
        ];
        return response()->json($data);
    }
}
