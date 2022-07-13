@extends('admin.layouts.master')
@section('content')
<style type="text/css">
    .iti{
        width: 100%;
    }
</style>
<link rel="stylesheet" href="{{ url('website/phone/css/intlTelInput.css') }}">
<!-- Begin Page Content -->
<div class="container-fluid">


<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
        <div class="card-header">
            Add Admin SMS Number
        </div>
        <div class="card-body">
            <div class="row">
               
                <div class="col-md-12">
                    <form id="formsubmitid" action="{{route('admin.smsnumberprocess')}}" method="POST" enctype="multipart/form-data" id="categoryFRM">
                        @csrf
                        <div class="row form-group">
                            <label style="margin-bottom: 5px;">Phone<span>*</span></label>
                            <input id="phone" class="customerReg form-control" name="phone" type="tel">
                            <input type="hidden" name="mobilenumber" id="mobilenumber">
                        </div>
                        <div class="row form-group">
                          
                               <span onclick="submitformforsms()" type="btn" class="btn btn-success categorieSubmit">Submit</span>
                        </div>

                       
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    <div class="col-lg-8">
<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Admin SMS Number</h6>
        <!-- <a href="{{route('admin.addcategories')}}"><button type="btn" class="btn btn-round btn-success" style="float:right">Add Category</button></a> -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Action</th>                        
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($data as $r)
                    <tr>
                        <td>{{$r->number}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark">Action</button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">                                
                                    <li><a href="{{route('admin.deletesms',[encrypt($r->id)])}}" class="dropdown-item">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>

</div>
<!-- /.container-fluid -->
<script src="{{ url('website/phone/js/intlTelInput.js') }}"></script>
<script type="text/javascript">
    function submitformforsms()
    {
        var txt = $('.iti__selected-dial-code').text();
        var phone = $('#phone').val();
        $('#mobilenumber').val(txt+phone);
        $('#formsubmitid').submit();
    }
</script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      // allowDropdown: false,
       autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      formatOnDisplay: true,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      hiddenInput: "full_phone",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      placeholderNumberType: "MOBILE",
      preferredCountries: ['qa'],
      separateDialCode: true,
      utilsScript: "{{ url('website/phone/js/utils.js') }}?1638200991544",
    });
  </script>
@stop