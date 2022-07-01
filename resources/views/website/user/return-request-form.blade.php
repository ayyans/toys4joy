@extends('website.layouts.master')
@section('content')
<main id="return-exchange">
  <div class="container-fluid">
    <form action="{{ route('website.return-request') }}" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-6">
          <div class="want-to-return">
            <h3>Why do you want to return this item?</h3>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="reason" id="first_option" value="The item isn't working properly." checked>
              <label class="form-check-label" for="first_option">
                The item isn't working properly.
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="reason" id="second_option" value="I received wrong item.">
              <label class="form-check-label" for="second_option">
                I received wrong item.
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="reason" id="third_option" value="Product was damaged.">
              <label class="form-check-label" for="third_option">
                Product was damaged.
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="reason" id="fourth_option" value="Part of the product is missing.">
              <label class="form-check-label" for="fourth_option">
                Part of the product is missing.
              </label>
            </div>
            <div class="form-group message">
              <label>Tell Us More</label>
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
            <label>Attach copy of your receipt</label>
            <button type="submit" class="vertical-shake">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</main>
@endsection