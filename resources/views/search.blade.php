@extends('layouts.admin')
@section('content')
<main class="w-full flex-grow p-6">
    <h1 class="w-full text-3xl text-black pb-6">Search Form</h1>

    <div class="flex flex-wrap">
        <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
            <div class="leading-loose">
                <form action="{{ route('xm.search') }}" id="search_form" method="post" enctype="multipart/form-data" class="p-10 bg-white rounded shadow-xl" autocomplete="off">
                    @csrf

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="company_symbol">Company Symbol</label>
                        <select class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" id="company_symbol" name="company_symbol" required="" aria-label="company_symbol">
                            @foreach(App\Helpers\NasdaqListings::getCompaniesDropdown() as $symbol => $name)
                                <option value="{{ $symbol }}" 
                                    @if( isset($requestData['company_symbol']) && $requestData['company_symbol'] == $symbol ) 
                                        selected 
                                    @elseif( old('company_symbol') == $symbol )
                                        selected
                                    @endif
                                >
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="start_date">Start Date</label>
                        <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="start_date" name="start_date" type="text" required="" placeholder="Start Date" aria-label="start_date" value="{{ $requestData['start_date'] ?? old('start_date')  }}">
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="end_date">End Date</label>
                        <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="end_date" name="end_date" type="text" required="" placeholder="End Date" aria-label="end_date" value="{{ $requestData['end_date'] ?? old('end_date')  }}">
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="email">Email</label>
                        <input class="w-full px-5  py-1 text-gray-700 bg-gray-200 rounded" id="email" name="email" type="text" required="" placeholder="Your Email" aria-label="Email" value="{{ $requestData['email'] ?? old('email')  }}">
                    </div>
                    <div class="mt-6">
                        <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(isset($dateRangeData))
    <div class="w-full mt-6">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Search Results
        </p>
        <div class="bg-white overflow-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Date</th>
                        <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Open</th>
                        <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">High</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Low</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Close</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Volume</th>

                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($dateRangeData as $index => $tableRowData)
                    <tr @if($index % 2 == 0) class="bg-gray-200" @endif>
                        <td class="w-1/3 text-left py-3 px-4">{{ $tableRowData['date'] }}</td>
                        <td class="w-1/3 text-left py-3 px-4">{{ $tableRowData['open'] }}</td>
                        <td class="w-1/3 text-left py-3 px-4">{{ $tableRowData['high'] }}</td>
                        <td class="text-left py-3 px-4">{{ $tableRowData['low'] }}</td>
                        <td class="text-left py-3 px-4">{{ $tableRowData['close'] }}</td>
                        <td class="text-left py-3 px-4">{{ $tableRowData['volume'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="w-full mt-6">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Chart
        </p>
        <div id="chart"></div>
    </div>
    @endif
</main>

@include('searchJs')

@endsection