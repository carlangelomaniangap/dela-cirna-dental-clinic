<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta description="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div class="bg-[#4b9cd3;] shadow-[0_2px_4px_rgba(0,0,0,0.4)] py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-10">
        <h4><i class="fa-solid fa-calendar-days"></i> Update Calendar</h4>
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('admin.updatedCalendar', $calendar->id) }}" class="w-1/2 mx-auto bg-white rounded-lg shadow-md p-10">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $calendar->name) }}" required>
        </div>
        <div class="mb-4">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $calendar->description) }}" required>
        </div>
        <div class="mb-4 form-inline">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" style="width: 40%;" id="date" name="date" value="{{ old('date', $calendar->date) }}" required>
            
            <label for="time" class="form-label time">Time</label>
            <input type="time" class="form-control" style="width: 40%;" id="time" name="time" value="{{ old('time') }}" required>
        </div>
        <div class="text-right">
            <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-regular fa-calendar-check"></i> Update</button>
            <a href="{{ route('admin.calendar') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800"><i class="fa-regular fa-calendar-minus"></i> Cancel</a>
        </div>
    </form>
</body>
</html>

@section('title')
    Update Calendar
@endsection

</x-app-layout>