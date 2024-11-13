<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen">

    <div style="background: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="py-4 px-6 text-white">
        <h4 class="text-lg sm:text-xl lg:text-2xl font-semibold">{{ __('Dashboard') }}</h4>
    </div>

    @if(session('status') || $errors->any())
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="relative p-4 w-full max-w-md">
                <div class="relative p-5 text-center bg-white rounded-lg shadow">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center" onclick="this.closest('.fixed').style.display='none'">
                        <i class="fa-solid fa-xmark text-lg"></i>
                        <span class="sr-only">Close modal</span>
                    </button>

                    @if(session('status'))
                        <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-check text-green-500 text-2xl"></i>
                            <span class="sr-only">Success</span>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-full bg-red-100 p-2 flex items-center justify-center mx-auto mb-3.5">
                            <i class="fa-solid fa-xmark text-red-500 text-2xl"></i>
                            <span class="sr-only">Error</span>
                        </div>
                    @endif

                    @if(session('status'))
                        <p class="mb-4 text-lg font-semibold text-gray-900">{{ session('status') }}</p>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="mb-4 text-lg font-semibold text-red-600">{{ $error }}</p>
                        @endforeach
                    @endif

                    @if(session('status'))
                        <button type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300" onclick="this.closest('.fixed').style.display='none'">
                            Continue
                        </button>
                    @else
                        <button type="button" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300" onclick="this.closest('.fixed').style.display='none'">
                            Continue
                        </button>
                    @endif
                    
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto">
        <div class="p-6">

            <!-- Clinic List -->
            <div class="space-y-4">
                @foreach($dentalclinics as $dentalclinic)
                    <div class="flex items-center justify-between bg-white border border-gray-200 shadow-md rounded-lg p-4 transition-transform transform hover:scale-105 hover:shadow-2xl duration-300">
                            
                        <!-- Clinic Logo -->
                        <div class="flex-shrink-0 mr-4">
                            @if($dentalclinic->logo)
                                <div class="aspect-w-1 aspect-h-1 w-10 h-10 lg:w-16 lg:h-16 rounded-full overflow-hidden bg-gray-200">
                                    <img src="{{ asset('logos/' . $dentalclinic->logo) }}" alt="Logo" class="object-cover w-full h-full">
                                </div>
                            @else
                                <span class="text-gray-400">No logo</span>
                            @endif
                        </div>

                        <!-- Clinic Info (Name, Status) -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm lg:text-lg font-semibold text-gray-700">{{ $dentalclinic->dentalclinicname }}</p>
                            <p class="text-xs lg:text-sm text-gray-500 mt-1">
                                Status: 
                                @if($dentalclinic->status === 'pending')
                                    <span class="text-blue-500">Pending</span>
                                @else
                                    <span class="text-green-500">Approved</span>
                                @endif
                            </p>
                        </div>

                        <!-- Approve Button for Pending Clinics -->
                        @if($dentalclinic->status === 'pending')
                            <form action="{{ route('dentalclinics.approve', $dentalclinic->id) }}" method="POST" class="ml-4">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-yellow-500 text-white text-xs lg:text-base px-2 py-1 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Approve
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

        </div>
    </div>

</body>
</html>

@section('title')
    Dashboard
@endsection

</x-app-layout>