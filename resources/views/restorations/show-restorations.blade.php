
@extends('layouts.main')

@section('content')
    <h1>Restorations Details</h1>

    <div class='card'>
        <div class='card-body'>
            <div class='table-responsive'>
                <table class='table'>
                    <tr>
                        <th>ID</th>
                        <td>{{ $item->id }}</td>
                    </tr>
                    
        <tr>
            <th>Name</th>
            <td>{{ $item->name }}</td>
        </tr>
    
        <tr>
            <th>SiteId</th>
            <td>{{ $item->siteId }}</td>
        </tr>
    
        <tr>
            <th>Time</th>
            <td>{{ $item->time }}</td>
        </tr>
    
        <tr>
            <th>Troubleshoot</th>
            <td>{{ $item->troubleshoot }}</td>
        </tr>
    
                    <tr>
                        <th>Created At</th>
                        <td>{{ Smark\Smark\Dater::humanReadableDateWithDayAndTime($item->created_at) }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ Smark\Smark\Dater::humanReadableDateWithDayAndTime($item->updated_at) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <a href='{{ route('restorations.index') }}' class='btn btn-primary'>Back to List</a>
@endsection
