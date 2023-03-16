
@include('master-pages.header');
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
            @include('master-pages.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                    @include('master-pages.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                    @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

    
    @include('master-pages.footer')

</body>

</html>