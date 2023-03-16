@extends('master-pages.body');
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ URL('/admin/master/city/create') }}" class="btn btn-primary btn-square btn-sm">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <!-- Content Row -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">    
                  
            </div>
            <div class="card-body">
                <p><b>Select Material Management Option from Sidebar to Continue</b></p>
            </div>
        </div>

</div>
@endsection