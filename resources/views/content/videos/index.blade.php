@extends('layouts/contentNavbarLayout', ['active' => 'videos'])

@section('title', 'Videos Manage - V&E')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Videos</h1>
        <p class="mb-4">Hiển thị đầy đủ danh sách video và có thể tìm kiếm theo nhiều tiêu chí.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Video Infomation</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>USER NAME</th>
                                <th>LINK VIDEO</th>
                                <th>STATUS</th>
                                <th>COMMENT</th>
                                <th>DATE UPLOAD</th>
                                <th>LIKE COUNT</th>
                                <th width="50px">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videos as $key => $video)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $video->user->full_name }}</td>
                                    <td>
                                        <a target="blank" href="{{ $video->url }}">
                                            {{ $video->description }}
                                        </a>
                                    </td>
                                    <td>{{ $video->getStatusText() }}</td>
                                    <td>{{ $video->comment ? "Cho phép" : "Không cho phép" }}</td>
                                    <td>{{ $video->date_upload }}</td>
                                    <td>{{ $video->likes_count }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary m-1" data-toggle="tooltip" data-placement="right" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger m-1" data-toggle="tooltip" data-placement="right" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
@endsection
