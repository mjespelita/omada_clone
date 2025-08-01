
@extends('layouts.main')

@section('content')
    <h1>Clients - {{ $item->name }}</h1>

    <x-internal-sidebar :item="$item" />

    <div class='card'>
        <div class='card-body'>

            {{-- <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <button type='button' style="font-size: 12px" class='p-1 btn btn-outline-secondary'>ALL</button>
                    <button type='button' style="font-size: 12px" class='p-1 btn btn-outline-secondary'>WIRELESS</button>
                    <button type='button' style="font-size: 12px" class='p-1 btn btn-outline-secondary'>WIRED</button>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <form action='{{ url('/customers-filter') }}' method='get'>
                        <div class='input-group'>
                            <input type='date' class='form-control' id='from' name='from' required>
                            <b class='pt-2'>- to -</b>
                            <input type='date' class='form-control' id='to' name='to' required>
                            <div class='input-group-append'>
                                <button type='submit' class='btn btn-primary form-control'><i class='fas fa-filter'></i> Filter</button>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
            </div> --}}

            <div>
                <div class="row" id="clientStatSummary">
                    <div class="loadingPlaceholder" style="width: 100%; text-align: center; padding: 50px 0;">
                        <div style="display: inline-block; width: 3rem; height: 3rem; border: 0.4rem solid #ccc; border-top-color: #007bff; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                        <div style="margin-top: 1rem; color: #888;">Loading client statistics...</div>
                    </div>
                </div>
            </div>

            <!-- Inline spinner animation style -->
            <style>
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            </style>

            <div class='table-responsive mt-2'>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>MAC Address</th>
                            <th>Device Name</th>
                            <th>Device Type</th>
                            <th>Connected Device Type</th>
                            <th>Switch Name</th>
                            <th>Port</th>
                            <th>Standard Port</th>
                            <th>Network Name</th>
                            <th>Uptime (s)</th>
                            <th>Traffic Down</th>
                            <th>Traffic Up</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="clientTableBody">
                        <tr>
                            <td colspan="12" style="text-align: center; padding: 50px 0;">
                                <div style="display: inline-block; width: 3rem; height: 3rem; border: 0.4rem solid #ccc; border-top-color: #007bff; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                                <div style="margin-top: 1rem; color: #888;">Loading client data...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="clientDetailModal" tabindex="-1" aria-labelledby="clientDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="clientDetailModalLabel">Client Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="clientDetailBody">
                        <div class="spinner-border"></div> Loading...
                    </div>
                </div>
                </div>
            </div>

        </div>
    </div>

    <a href='{{ route('sites.index') }}' class='btn btn-primary'>Back to List</a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            function loadClientData(siteId) {
                $.ajax({
                    url: `/clients-api/${siteId}`,
                    method: 'GET',
                    success: function (res) {
                        const container = $('#clientTableBody');
                        container.empty();

                        const statContainer = $('#clientStatSummary');
                        statContainer.empty();

                        console.log(res)

                        if (res.clients.length != 0) {
                            const data = res;
                            if (res.clients.length > 0) {
                                res.clients.forEach(client => {
                                    const row = `
                                        <tr>
                                            <td>
                                                <b class="text-primary" style="cursor:pointer" data-mac="${client.mac_address}" class="client-mac-link">${client.mac_address || '-'}</b>
                                            </td>
                                            <td>${client.device_name || '-'}</td>
                                            <td>${client.device_type || '-'}</td>
                                            <td>${client.connected_device_type || '-'}</td>
                                            <td>${client.switch_name || '-'}</td>
                                            <td>${client.port ?? '-'}</td>
                                            <td>${client.standard_port || '-'}</td>
                                            <td>${client.network_theme || '-'}</td>
                                            <td>${client.uptime ?? '-'}</td>
                                            <td>${client.traffic_down ? (client.traffic_down / 1_000_000).toFixed(2) + ' MB' : '-'}</td>
                                            <td>${client.traffic_up ? (client.traffic_up / 1_000_000).toFixed(2) + ' MB' : '-'}</td>
                                            <td>${client.status ? '<span class="text-success">Active</span>' : '<span class="text-muted">Inactive</span>'}</td>
                                        </tr>
                                    `;
                                    container.append(row);
                                });

                                // Click handler for MAC address
                                $('#clientTableBody').on('click', 'b[data-mac]', function () {
                                    const mac = $(this).data('mac');
                                    const siteId = window.location.pathname.split('/').filter(Boolean).pop();

                                    $('#clientDetailBody').html('Loading...');
                                    $('#clientDetailModal').modal('show');

                                    $.get(`/client-details-api/${siteId}/${mac}`, function (res) {
                                        if (res.errorCode === 0) {
                                            const d = res.result;
                                            const detailHtml = `
                                                <table class="table table-bordered">
                                                    <tr><th>MAC</th><td>${d.mac}</td></tr>
                                                    <tr><th>Name</th><td>${d.name}</td></tr>
                                                    <tr><th>Device Type</th><td>${d.deviceType}</td></tr>
                                                    <tr><th>Switch</th><td>${d.switchName} (${d.switchMac})</td></tr>
                                                    <tr><th>Port</th><td>${d.port} (${d.standardPort})</td></tr>
                                                    <tr><th>Traffic Down</th><td>${(d.trafficDown / 1_000_000).toFixed(2)} MB</td></tr>
                                                    <tr><th>Traffic Up</th><td>${(d.trafficUp / 1_000_000).toFixed(2)} MB</td></tr>
                                                    <tr><th>Uptime</th><td>${d.uptime} seconds</td></tr>
                                                    <tr><th>Guest</th><td>${d.guest ? 'Yes' : 'No'}</td></tr>
                                                    <tr><th>Blocked</th><td>${d.blocked ? 'Yes' : 'No'}</td></tr>
                                                </table>
                                            `;
                                            $('#clientDetailBody').html(detailHtml);
                                        } else {
                                            $('#clientDetailBody').html('<div class="text-danger">Failed to load client details.</div>');
                                        }
                                    }).fail(function () {
                                        $('#clientDetailBody').html('<div class="text-danger">Request failed.</div>');
                                    });
                                });

                            } else {
                                container.html(`<tr><td colspan="12" class="text-center text-muted">No client data found.</td></tr>`);
                            }

                            const stat = res.clientStat;
                            const statCards = `
                                <div class="col-md-3 mb-3"><div class="card p-3"><strong>Total Clients:</strong> <h1>${stat[0].total}</h1></div></div>
                                <div class="col-md-3 mb-3"><div class="card p-3"><strong>Wired:</strong> <h1>${stat[0].wired}</h1></div></div>
                                <div class="col-md-3 mb-3"><div class="card p-3"><strong>Wireless:</strong> <h1>${stat[0].wireless}</h1></div></div>
                                <div class="col-md-3 mb-3"><div class="card p-3"><strong>Guests:</strong> <h1>${stat[0].numGuest}</h1></div></div>
                                <div class="col-md-3 mb-3"><div class="card p-3"><strong>Users:</strong> <h1>${stat[0].numUser}</h1></div></div>
                                <div class="col-md-3 mb-3"><div class="card p-3"><strong>Good Signal:</strong> <h1>${stat[0].good}</h1></div></div>
                                <div class="col-md-3 mb-3"><div class="card p-3"><strong>Fair Signal:</strong> <h1>${stat[0].fair}</h1></div></div>
                                <div class="col-md-3 mb-3"><div class="card p-3"><strong>No Signal Data:</strong> <h1>${stat[0].noData}</h1></div></div>
                            `;
                            statContainer.append(statCards);
                        } else {
                            container.html(`<tr><td colspan="12" class="text-center text-muted">No client data found.</td></tr>`);
                            statContainer.html(`<div class="col-12 text-danger text-center">Failed to load client stats.</div>`);
                        }
                    },
                    error: function (err) {
                        console.log(err)
                        $('#clientTableBody').html(`<tr><td colspan="12" class="text-danger text-center">Failed to load client data.</td></tr>`);
                    }
                });
            }

            $.get('/traffic-api-access-token', function () {
                const siteId = window.location.pathname.split('/').filter(Boolean).pop();
                loadClientData(siteId);
            }).fail(function () {
                console.error("Failed to fetch access token.");
            });
        });
    </script>
@endsection
