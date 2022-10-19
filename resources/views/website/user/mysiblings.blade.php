@extends('website.layouts.master')
@section('content')
<main id="my-siblings">
<div class="container-fluid">
    <div class="row">
        <div class="col-1"></div>
    	<div class="col-10 content-block">
            <div class="d-flex welcome-block">
                <img src="{{ url('website/img/user-pic.png') }}"/>
                <h2>{{__('trans.Welcome Back')}} {{ Auth::user()->name }}</h2>
            </div>
            <form id="siblingsupdate" method="POST" action="{{ url('siblingsupdate') }}">
            <div class="siblings-table row">
                    <div class="col-6">
                        <div class="text-center sibling my-sister">
                            <div class="sib-img">
                                <h4>{{__('trans.My Sisters')}}</h4>
                                <img src="{{ url('website/img/sisters.png') }}"/>
                            </div>
                            <table class="table">
                              <thead>
                                <tr>
                                  <th class="first">{{__('trans.Name')}}</th>
                                  <th class="last">{{__('trans.Date of Birth')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    <td class="name"><input value="{{ $data->girl_one_name }}" name="girl_one_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->girl_one_dob }}" name="girl_one_dob" type="date"/></td>
                                </tr>
                                <tr>
                                    <td class="name"><input value="{{ $data->girl_tow_name }}" name="girl_tow_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->girl_tow_dob }}" name="girl_tow_dob" type="date"/></td>
                                </tr>
                                <tr>
                                    <td class="name"><input value="{{ $data->girl_three_name }}" name="girl_three_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->girl_three_dob }}" name="girl_three_dob" type="date"/></td>
                                </tr>
                                <tr>
                                    <td class="name"><input value="{{ $data->girl_four_name }}" name="girl_four_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->girl_four_dob }}" name="girl_four_dob" type="date"/></td>
                                </tr>
                                <tr>
                                    <td class="name"><input value="{{ $data->girl_five_name }}" name="girl_five_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->girl_five_dob }}" name="girl_five_dob" type="date"/></td>
                                </tr>
                              </tbody>    
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="text-center sibling my-brother">
                            <div class="sib-img">
                                <h4>{{__('trans.My Brothers')}}</h4>
                                <img src="{{ url('website/img/brothers.png') }}"/>
                            </div>
                            <table class="table">
                              <thead>
                                <tr>
                                  <th class="first">{{__('trans.Name')}}</th>
                                  <th class="last">{{__('trans.Date of Birth')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                    <td class="name"><input value="{{ $data->boy_one_name }}" name="boy_one_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->boy_one_dob }}" name="boy_one_dob" type="date"/></td>
                                </tr>
                                <tr>
                                    <td class="name"><input value="{{ $data->boy_tow_name }}" name="boy_tow_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->boy_tow_dob }}" name="boy_tow_dob" type="date"/></td>
                                </tr>
                                <tr>
                                    <td class="name"><input value="{{ $data->boy_three_name }}" name="boy_three_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->boy_three_dob }}" name="boy_three_dob" type="date"/></td>
                                </tr>
                                <tr>
                                    <td class="name"><input value="{{ $data->boy_four_name }}" name="boy_four_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->boy_four_dob }}" name="boy_four_dob" type="date"/></td>
                                </tr>
                                <tr>
                                    <td class="name"><input value="{{ $data->boy_five_name }}" name="boy_five_name" type="text"/></td>
                                    <td class="dob"><input value="{{ $data->boy_five_dob }}" name="boy_five_dob" type="date"/></td>
                                </tr>
                                
                              </tbody>    
                            </table>
                        </div>
                    </div>
                    
                </div>
                </form>
            <div class="btn pinkbg-img">
                <a onclick="siblingsupdate()">{{__('trans.Submit')}}</a>
            </div>
        </div>
        <div class="col-1"></div>
  </div>      
</div>

</main>
<script type="text/javascript">
    function siblingsupdate()
    {
        $('#siblingsupdate').submit();
    }
</script>
@endsection
