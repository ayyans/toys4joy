@extends('admin.layouts.master')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">General Settings</h1>
  </div>

  <div class="row">
    <div class="col">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Points System</h6>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.settings.store') }}" method="post">
            <div class="row">
              <div class="col-6">
                {{-- Left Side --}}
                <div class="form-group">
                  <label for="qar_in_points">QAR in Points Reward</label>
                  <input type="number" class="form-control" name="qar_in_points" id="qar_in_points" value="{{ $settings['qar_in_points'] ?? 2 }}">
                </div>
                <div class="form-group">
                  <label for="reward_on_threshold">Reward Giftcard on Threshold</label>
                  <input type="number" class="form-control" name="reward_on_threshold" id="reward_on_threshold" value="{{ $settings['reward_on_threshold'] ?? 100 }}">
                </div>
              </div>
              <div class="col-6">
                {{-- Right Side --}}
                <div class="form-group">
                  <label for="points_threshold">Points Threshold</label>
                  <input type="number" class="form-control" name="points_threshold" id="points_threshold" value="{{ $settings['points_threshold'] ?? 5000 }}">
                </div>
              </div>
              <div class="col-12 text-right">
                <button type="submit" class="btn btn-primary">Save Settings</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection