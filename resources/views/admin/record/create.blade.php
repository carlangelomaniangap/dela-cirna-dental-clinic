<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body>
    <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="header py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-10">
        <h4>Add Record</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form method="post" action="{{ route('admin.record.store') }}" enctype="multipart/form-data" class="w-1/2 mx-auto bg-white rounded-lg shadow-md p-10">
        @csrf
        <input type="hidden" name="patientlist_id" value="{{ $patientlist->id }}">
        
        <div class="mb-3">
            <label for="file" class="form-label">File</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>
        <div class="text-right">
            <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white">Upload File</button>
            <a href="{{ route('admin.showRecord', $patientlist->id) }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Back to View Record</a>
        </div>
    </form>
</body>
</html>

@section('title')
    Add Record
@endsection

</x-app-layout>