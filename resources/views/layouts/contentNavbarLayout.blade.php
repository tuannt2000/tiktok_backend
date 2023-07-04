@extends('layouts/commonMaster')

@section('layoutContent')
    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layouts/sections/sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts/sections/topbar')
                @yield('content')
            </div>
            <!-- End of Main Content -->

            @include('layouts/sections/footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('layouts/sections/logout')
@endsection
