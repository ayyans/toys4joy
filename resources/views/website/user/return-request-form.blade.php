@extends('website.layouts.master')
@section('content')
<main id="return-exchange">
  <div class="container-fluid">
    <form action="{{ route('website.return-request') }}" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-6">
          <div class="want-to-return">
            <h3>{{__('trans.Why do you want to return this item?')}}</h3>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="reason" id="first_option" value="The item isn't working properly." checked>
              <label class="form-check-label" for="first_option">
              {{__("trans.The item isn't working properly.")}}
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="reason" id="second_option" value="I received wrong item.">
              <label class="form-check-label" for="second_option">
              {{__('trans.I received wrong item.')}}
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="reason" id="third_option" value="Product was damaged.">
              <label class="form-check-label" for="third_option">
              {{__('trans.Product was damaged.')}}
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="reason" id="fourth_option" value="Part of the product is missing.">
              <label class="form-check-label" for="fourth_option">
              {{__('trans.Part of the product is missing.')}}
              </label>
            </div>
            <div class="form-group message">
              <label>{{__('trans.Tell Us More')}}</label>
              <textarea name="detail" required></textarea>
            </div>
          </div>
        </div>
        <div class="col-6 member-col right text-center">
          <div class="attach-area">
            <div class="attach-file">
              <input type="file" id="receipt" name="receipt">
              <label for="receipt"><img src="{{ asset('website/img/attach.png') }}" /></label>
            </div>
            <label>{{__('trans.Attach copy of your receipt')}}</label>
            <button type="submit" class="vertical-shake">{{__('trans.Submit')}}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</main>
@endsection
