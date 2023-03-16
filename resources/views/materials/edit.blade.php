@extends('master-pages.body')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">New Material Form</h1>
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
                <form action="{{ url('/materials') }}/{{ $data['id'] }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Material Name&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $data['name'] }}" id="name">
                            @if ($errors->has('name'))
                                <label for="" class="text-danger">{{ $errors->first('name') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="">Category&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            {{-- <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name"> --}}
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @if ($categories['count'] > 0)
                                    @foreach ($categories['data'] as $item)
                                        <option @selected($data['category_id']) value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">No Data Available</option>
                                @endif
                            </select>
                            @if ($errors->has('category_id'))
                                <label for="" class="text-danger">{{ $errors->first('category_id') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="">Opening BLC&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <input type="text" min="1" step=".01" class="form-control" name="opening_blc" value="{{ $data['opening_blc'] }}" id="opening_blc">
                            @if ($errors->has('opening_blc'))
                                <label for="" class="text-danger">{{ $errors->first('opening_blc') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 d-flex justify-content-start">
                            <button class="btn btn-primary" id="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

</div>

<script>
    $(document).ready(function(){
        document.querySelector(`#name`).onkeypress = e => /[a-zA-Z0-9\s]/i.test(e.key);
    });
</script>

@endsection
