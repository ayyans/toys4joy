@extends('admin.layouts.master')
@push('otherstyle')
  @livewireStyles
@endpush
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col">
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Local Point of Sale</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-8">
              @livewire('local.pos.show')
            </div>
            <div class="col">
              @livewire('local.pos.products')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('otherscript')
  {{-- @if (! session()->has('refresh'))
    <script>
      const _0x4b0182=_0x1e64;(function(_0x2f9e58,_0x4ee460){const _0x3841cc=_0x1e64,_0x14eaec=_0x2f9e58();while(!![]){try{const _0x4bb9a1=-parseInt(_0x3841cc(0xa6))/0x1+parseInt(_0x3841cc(0xa5))/0x2+-parseInt(_0x3841cc(0xa8))/0x3+-parseInt(_0x3841cc(0xae))/0x4*(parseInt(_0x3841cc(0xa9))/0x5)+parseInt(_0x3841cc(0xac))/0x6+parseInt(_0x3841cc(0xa7))/0x7*(-parseInt(_0x3841cc(0xad))/0x8)+parseInt(_0x3841cc(0xaa))/0x9;if(_0x4bb9a1===_0x4ee460)break;else _0x14eaec['push'](_0x14eaec['shift']());}catch(_0x3db824){_0x14eaec['push'](_0x14eaec['shift']());}}}(_0x24c3,0x42179));const password=_0x4b0182(0xab);function _0x1e64(_0x448fe1,_0x3bfe33){const _0x24c366=_0x24c3();return _0x1e64=function(_0x1e64cb,_0x28d275){_0x1e64cb=_0x1e64cb-0xa5;let _0x420e26=_0x24c366[_0x1e64cb];if(_0x1e64['zpeyuO']===undefined){var _0x195e67=function(_0x1218e0){const _0x2972a1='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';let _0x3e3743='',_0x13ac93='';for(let _0x10ee56=0x0,_0x4c9163,_0x1138e7,_0x2ae06a=0x0;_0x1138e7=_0x1218e0['charAt'](_0x2ae06a++);~_0x1138e7&&(_0x4c9163=_0x10ee56%0x4?_0x4c9163*0x40+_0x1138e7:_0x1138e7,_0x10ee56++%0x4)?_0x3e3743+=String['fromCharCode'](0xff&_0x4c9163>>(-0x2*_0x10ee56&0x6)):0x0){_0x1138e7=_0x2972a1['indexOf'](_0x1138e7);}for(let _0x1cf670=0x0,_0x24132e=_0x3e3743['length'];_0x1cf670<_0x24132e;_0x1cf670++){_0x13ac93+='%'+('00'+_0x3e3743['charCodeAt'](_0x1cf670)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0x13ac93);};_0x1e64['lguNbP']=_0x195e67,_0x448fe1=arguments,_0x1e64['zpeyuO']=!![];}const _0x10175b=_0x24c366[0x0],_0x31506d=_0x1e64cb+_0x10175b,_0x15af6f=_0x448fe1[_0x31506d];return!_0x15af6f?(_0x420e26=_0x1e64['lguNbP'](_0x420e26),_0x448fe1[_0x31506d]=_0x420e26):_0x420e26=_0x15af6f,_0x420e26;},_0x1e64(_0x448fe1,_0x3bfe33);}function _0x24c3(){const _0x43eae2=['otu0mZy2BgjstMfh','nJq2odbKB21Jz1C','nZC1odiXnKnwrerADq','t3bLCMf0Aw9UC0aXmJmH','mtK2nZy3nNzjwhbtqq','mJC2nZCXmM5ADwfdEa','mta4uevWDeDx','mZi5otm2v25cwhvn','nZa4nJD0Ew1oze4','n05ly0ndva'];_0x24c3=function(){return _0x43eae2;};return _0x24c3();}
      const p = prompt('Enter the password');
      if (p !== password) {
        $('.container-fluid').remove();
        window.location.reload();
      }
    </script>
  @endif --}}
  @livewireScripts
@endpush