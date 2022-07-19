@extends('website.layouts.master')
@section('content')
<style type="text/css">
    .lable-area {
        padding: 10px;
    border: 1px solid skyblue;
}   
.star-lable{
    color: red;
    font-size: 20px;
}
.input-area{
    border-color: skyblue;
    padding: 9px 20px;
    margin-left: -5px;
}
.message-area{
  margin-left: 11px;
    padding-left: 24px;
}
.input-areas{
    border-color: skyblue;
    padding: 9px 75px;
    margin-left: -5px;
}
@media only screen and (max-width: 576px) {
    .textarea {
    width: 82%;
    margin-left: 80px;
}
}
@media screen and (max-width: 480px) {
    .textarea {
    width: 82%;
    margin-left: 80px;
}
}
@media only screen and (max-width: 600px) {
  .textarea {
    width: 82%;
    margin-left: 80px;
}
}
@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  .textarea {
    width: 82%;
    margin-left: 80px;
}
}
.textarea{
    width: 82%;
      border-color: skyblue;
    padding-left: 0px;
    margin-left: 16px;
}
.btn-div{
    text-align: end;
    margin-left: 25px;
}
.button{
    box-shadow: 0px -2px 19px red;
    color: white;
    background-color: red;
    padding: 20px;
}
</style>
<main id="my-account" class="account main-bg">
	<div class="container">
	    <div class="row content-block">
	        <div class="col-md-6 mt-3">
	            <label class="star-lable">*</label>
	            <label class="lable-area">Your Name</label>
	            <input class="input-areas" type="text" name="name">
	        </div>
	        <div class="col-md-6 col-lg-6 mt-3">
	            <label class="star-lable">*</label>
	            <label class="lable-area">Mobile Number</label>
	            <input class=" input-area" type="number" name="mobile">
	        </div>
	        <div class="col-md-1 col-lg-1 mt-3">
	            
	            <label class="lable-area message-area">Your Message</label>
	        </div>
	        <div class="col-md-11 col-lg-11 mt-3">
	            <textarea class="textarea"  rows="5"></textarea>
	        </div>
	       <div class="btn pinkbg-img"><a  href="javascript:void(0)">Update</a></div>
	    </div>
	</div>
</main>
@endsection