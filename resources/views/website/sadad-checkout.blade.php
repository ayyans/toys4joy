@extends('website.layouts.master')
@section('content')
<main>
  <div class="text-center">
    <h5 class="display-6 my-5">Redirecting to SADAD Checkout...</h1>
  </div>
  {!! $form ?? null !!}
</main>
@endsection
@push('otherscript')
<script>
  $('#paymentform').submit();
</script>
@endpush
