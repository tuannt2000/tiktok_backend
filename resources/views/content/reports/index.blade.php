@extends('layouts/contentNavbarLayout', ['active' => 'reports'])

@section('title', 'Reports Manage - V&E')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Reports</h1>
        <p class="mb-4">Hiển thị tất cả video bị báo cáo.</p>
        @include('elements.helpers.flash')
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Video Report</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>USER NAME</th>
                                <th>LINK VIDEO</th>
                                <th>CONTENT REPORTS</th>
                                <th>COUNT REPORT</th>
                                <th width="50px">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($video_reports as $key => $video_report)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $video_report->user->full_name }}</td>
                                    <td>
                                        <a target="blank" href="{{ $video_report->url }}">
                                            {{ $video_report->description }}
                                        </a>
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach($video_report->reports as $report)
                                                <li>{{ config('constants.reports')[$report->value] }}</li>
                                            @endforeach
                                        </ul>    
                                    </td>
                                    <td>{{ $video_report->reports_count }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('cancelReport', ['video_id' => $video_report->id]) }}">
                                            @csrf
                                            <button type="submit" id="cancel-button" class="btn btn-warning m-1" data-toggle="tooltip" data-placement="right" title="Cancel report">
                                                <i class="bi bi-x-circle-fill m-0"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('deleteVideoReport', ['video_id' => $video_report->id]) }}">
                                            @csrf
                                            <button type="submit" id="delete-button" class="btn btn-danger m-1" data-toggle="tooltip" data-placement="right" title="Delete video">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('vendor_js')
    <!-- Page level plugins -->
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/datatables-demo.js"></script>
    <script src="/js/report.js"></script>
@endsection
