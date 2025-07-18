
@extends('layouts.main')

@section('content')
    <h1>Insights - {{ $item->name }}</h1>

    <x-internal-sidebar :item="$item" />

    <div class='card'>
        <div class='card-body'>

            <div class='row'>
                <div class='col-lg-4 col-md-4 col-sm-12 mt-2'>
                    <div class='row'>
                        <div class='col-4'>
                            <button type='button' class='btn btn-outline-secondary dropdown-toggle' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                Action
                            </button>
                            <div class='dropdown-menu'>
                                <a class='dropdown-item bulk-move-to-trash' href='#'>
                                    <i class='fa fa-trash'></i> Move to Trash
                                </a>
                                <a class='dropdown-item bulk-delete' href='#'>
                                    <i class='fa fa-trash'></i> <span class='text-danger'>Delete Permanently</span> <br> <small>(this action cannot be undone)</small>
                                </a>
                            </div>
                        </div>
                        <div class='col-8'>
                            <form action='{{ url('/sites-paginate') }}' method='get'>
                                <div class='input-group'>
                                    <input type='number' name='paginate' class='form-control' placeholder='Paginate' value='{{ request()->get('paginate', 10) }}'>
                                    <div class='input-group-append'>
                                        <button class='btn btn-success' type='submit'><i class='fa fa-bars'></i></button>
                                    </div>
                                </div>
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class='col-lg-4 col-md-4 col-sm-12 mt-2'>
                    <form action='{{ url('/sites-filter') }}' method='get'>
                        <div class='input-group'>
                            <input type='date' class='form-control' id='from' name='from' required>
                            <b class='pt-2'>- to -</b>
                            <input type='date' class='form-control' id='to' name='to' required>
                            <div class='input-group-append'>
                                <button type='submit' class='btn btn-primary form-control'><i class='fas fa-filter'></i></button>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
                <div class='col-lg-4 col-md-4 col-sm-12 mt-2'>
                    <!-- Search Form -->
                    <form action='{{ url('/sites-search') }}' method='GET'>
                        <div class='input-group'>
                            <input type='text' name='search' value='{{ request()->get('search') }}' class='form-control' placeholder='Search...'>
                            <div class='input-group-append'>
                                <button class='btn btn-success' type='submit'><i class='fa fa-search'></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class='table-responsive mt-5'>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>MAC Address</th>
                            <th>IP Address</th>
                            <th>User/Guest</th>
                            <th>Download</th>
                            <th>Upload</th>
                            <th>Duration</th>
                            <th>Last Seen</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Sample Data Row 1 -->
                        <tr>
                            <td>06-39-4D-83-A3-F9</td>
                            <td>192.168.0.26</td>
                            <td class="status status-authorized">USER</td>
                            <td>2.3 MB</td>
                            <td>1.1 MB</td>
                            <td>5m 10s</td>
                            <td>Mar 15, 2025 05:25:30 AM</td>
                        </tr>

                        <!-- Sample Data Row 2 -->
                        <tr>
                            <td>06-40-4D-83-A3-F0</td>
                            <td>192.168.0.27</td>
                            <td class="status status-guest">GUEST</td>
                            <td>1.2 MB</td>
                            <td>0.5 MB</td>
                            <td>8m 23s</td>
                            <td>Mar 15, 2025 05:30:12 AM</td>
                        </tr>

                        <!-- Sample Data Row 3 -->
                        <tr>
                            <td>06-41-4D-83-A3-F1</td>
                            <td>192.168.0.28</td>
                            <td class="status status-authorized">USER</td>
                            <td>5.8 MB</td>
                            <td>2.2 MB</td>
                            <td>12m 01s</td>
                            <td>Mar 15, 2025 05:32:55 AM</td>
                        </tr>

                        <!-- Sample Data Row 4 -->
                        <tr>
                            <td>06-42-4D-83-A3-F2</td>
                            <td>192.168.0.29</td>
                            <td class="status status-guest">GUEST</td>
                            <td>3.1 MB</td>
                            <td>1.7 MB</td>
                            <td>15m 47s</td>
                            <td>Mar 15, 2025 05:35:44 AM</td>
                        </tr>

                        <!-- Sample Data Row 5 -->
                        <tr>
                            <td>06-43-4D-83-A3-F3</td>
                            <td>192.168.0.30</td>
                            <td class="status status-authorized">USER</td>
                            <td>7.5 MB</td>
                            <td>3.0 MB</td>
                            <td>18m 56s</td>
                            <td>Mar 15, 2025 05:40:20 AM</td>
                        </tr>

                    </tbody>
                </table>


            </div>

        </div>
    </div>

    <a href='{{ route('sites.index') }}' class='btn btn-primary'>Back to List</a>
@endsection
