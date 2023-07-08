@extends('layouts/contentNavbarLayout', ['active' => 'users'])

@section('title', 'Users Manage - V&E')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Users</h1>
        <p class="mb-4">Hiển thị đầy đủ thông tin user và có thể tìm kiếm theo nhiều tiêu chí.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User Infomation</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>EMAIL</th>
                                <th>NAME</th>
                                <th>NICK NAME</th>
                                <th>SOCIAL PROVIDER</th>
                                <th>TICK</th>
                                <th>BIO</th>
                                <th>FOLLOWER</th>
                                <th>FOLLOWING</th>
                                <th>PHONE</th>
                                <th width="50px">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->nickname }}</td>
                                    <td>{{ $user->social_provider }}</td>
                                    <td>{{ $user->tick ? 'Yes' : 'No' }}</td>
                                    <td>{{ $user->bio ?? 'No biography' }}</td>
                                    <td>{{ $user->follows_count }}</td>
                                    <td>{{ $user->followers_count }}</td>
                                    <td>{{ $user->phone ?? 'No phone' }}</td>
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
    <script src="/js/dataTables.bootstrap4.min.js'"></script>

    <!-- Page level custom scripts -->
    <script src="/js/datatables-demo.js"></script>
@endsection
