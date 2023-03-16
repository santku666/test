@extends('master-pages.body')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Category Form</h1>
    </div>

    <!-- Content Row -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">    
                  {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item active" aria-current="page"><a href="#">Create New Category</a></li>
       
                    </ol>
                  </nav> --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('error'))
                        <p class="text-danger">{{ Session::get('error') }}</p>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @isset($data)
                <form action="{{ url('/categories') }}/{{ $data['id'] }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Category Name&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{$data['name']}}" id="name">
                            @if ($errors->has('name'))
                                <label for="" class="text-danger">{{ $errors->first('name') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 d-flex justify-content-start">
                            <button class="btn btn-primary" id="submit">Submit</button>
                        </div>
                    </div>
                </form>
                @endisset
            </div>
        </div>

</div>

<script>
    $(document).ready(function(){
        document.querySelector(`#name`).onkeypress = e => /[a-zA-Z0-9\s]/i.test(e.key);
    });
</script>

@endsection
