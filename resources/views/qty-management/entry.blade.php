@extends('master-pages.body')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Inward Outward Entry Form</h1>
    </div>

    <!-- Content Row -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">    

            </div>
            <div class="row">
                <div class="col-md-12">
                        <p class="text-danger" id="general-err"></p>
                </div>
            </div>
            <div class="card-body">
                <form id="new-entry" method="POST">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="">Category&nbsp;&nbsp;</label>
                            {{-- <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name"> --}}
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @if ($categories['count'] > 0)
                                    @foreach ($categories['data'] as $item)
                                        <option @selected(old('category_id')==$item['id']) value="{{ $item['id'] }}">{{ $item['name'] }}</option>
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
                            <label for="">Material&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <select name="material_id" id="material_id" class="form-control">
                                <option value="">Please Select Category First</option>
                            </select>
                            <label for="" class="text-danger" id="material_id-err"></label>

                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="">Date&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date" id="date">
                            <label for="" class="text-danger" id="date-err"></label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="">Qty&nbsp;&nbsp;[-ve will be out +ve will be in]<span class="text-danger">*</span></label>
                            <input type="number" step=".01" class="form-control" name="qty" id="qty">
                            <label for="" class="text-danger" id="qty-err"></label>
                            
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

    const fields=["material_id","date","qty","general-err"];

    $(document).ready(function(){

        const createQty=(form_data)=>{
            try {
                fields.forEach(element => {
                    $(`#${element}-err`).empty();
                });
                axios.post(`{{ url('/qty-manager') }}`,form_data).then(
                    function(response){
                        window.location="{{ url('/qty-manager') }}";
                    }
                ).catch(
                    function(error){

                        console.log(error);
                        let error_message=error.response.data.message;
                        console.log(error_message);
                        if (typeof error_message==="object") {
                            for (const key in error_message) {
                                if (error_message.hasOwnProperty.call(error_message, key)) {
                                    const element = error_message[key];
                                    $(`#${key}-err`).html(error_message[key]);
                                }
                            }
                            
                        }else{
                            $("#general-err").html(error_message);
                        }

                        console.log('====================================');
                        console.log("Axios Error Occured"+error);
                        console.log('====================================');
                    }
                )
            } catch (error) {
                console.log('====================================');
                console.log("Javascript Error Occured "+error);
                console.log('====================================');
            }
        }

        const getMaterialsByCategory=(category_id)=>{
            try {
                axios.get(`{{ url('/api/materials/${category_id}/all') }}`).then(
                    function(response){
                        let serverData=response.data.serverData;
                        if (serverData.count > 0) {
                            let html=`<option value="">Select Material</option>`;
                            serverData.data.forEach(element => {
                                html+=`<option value="${element.id}">${element.name}</option>`;
                            });
                            $('#material_id').html(html);
                        }else{
                            let html=`<option value="">No Data Available</option>`
                            $('#material_id').html(html);
                        }
                    }
                ).catch(
                    function(error){
                        console.log('====================================');
                        console.log("Axios Error Occured"+error);
                        console.log('====================================');
                    }
                )
            } catch (error) {
                console.log('====================================');
                console.log("Javascript Error Occured "+error);
                console.log('====================================');
            }
        }
        
        $('#category_id').change(function(e){
            getMaterialsByCategory(e.target.value);
        });
        $('#new-entry').submit(function(e){
            e.preventDefault();
            let form_data=new FormData(e.target);
            createQty(form_data);
        })
    });
</script>

@endsection
