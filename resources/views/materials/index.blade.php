@extends('master-pages.body')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master materials</h1>
        <a href="{{ url('materials/create') }}" class="btn btn-primary btn-square btn-sm">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <!-- Content Row -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">    
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      {{-- <li class="breadcrumb-item active" aria-current="page"><a href="#">Master Categories</a></li> --}}
       
                    </ol>
                  </nav>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr no</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Opening Blc</th>
                                <th style="width: 10px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($result)
                                @if ($result->total() > 0)
                                    @foreach ($result as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['category']['name'] }}</td>
                                            <td>{{ $item['opening_blc'] }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <a class="btn btn-info btn-sm" href="{{ url('/materials') }}/{{ $item['id'] }}/edit">edit</a>
                                                    <form action="{{ url('materials') }}/{{ $item['id'] }}" method="POST">
                                                        @method("delete")
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm">delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">No Records Available</td>
                                    </tr>
                                @endif
                            @endisset
                        </tbody>
                    </table>
                    <div class="" id="pagination">
                        @isset($result)
                            {{ $result->withQueryString()->links('pagination::bootstrap-4') }}
                        @endisset
                    </div>
                </div>
            </div>
        </div>

</div>
@endsection