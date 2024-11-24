<x-layout>
    <x-slot:breadcrumb>
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active" aria-current="page">Room List</li>
    </x-slot:breadcrumb>
    <x-slot:title>
        Room List
    </x-slot:title>
    <x-slot:action>
        <a href="{{ route('room.add') }}" class="btn btn-primary"><i data-feather="plus"></i>Add Room</a>
    </x-slot:action>

    @if (session('notification'))
        <x-message>
            <x-slot:type>{{ session('notification.type') }}</x-slot:type>
            <x-slot:message>{{ session('notification.message') }}</x-slot:message>
        </x-message>
    @endif
    <x-modal>
        <x-slot:modalTitle>
            Delete Room
        </x-slot:modalTitle>
        <x-slot:modalContent>
            <p>Are you sure you want to delete the room number <span id="roomNumberDelete"></span>?</p>
        </x-slot:modalContent>
        <x-slot:modalFooter>
            <form id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </x-slot:modalFooter>
    </x-modal>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Room Number</th>
                        <th scope="col">Children Capacity</th>
                        <th scope="col">Adult Capacity</th>
                        <th scope="col">Price</th>
                        <th scope="col" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room->roomNumber }}</td>
                            <td>{{ $room->childrenCapacity }}</td>
                            <td>{{ $room->adultCapacity }}</td>
                            <td>{{ $room->price }}</td>
                            <td>
                                <div class="d-flex flex-col justify-content-end gap-2">
                                    <a href="{{ route('room.detail', $room->id) }}" class="btn btn-sm btn-primary"><i
                                            data-feather="edit"></i></a>
                                    <button id="deleteRoom"
                                        onclick="deleteRoom({{ $room->id }},{{ $room->roomNumber }})" type="submit"
                                        class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
    <script>
        function deleteRoom(roomId, roomNumber) {
            // Set room number in the modal
            document.getElementById('roomNumberDelete').textContent = roomNumber;

            // Update form action with the correct URL
            document.getElementById('formDelete').action = `/rooms/delete/${roomId}`;
        }
    </script>

</x-layout>