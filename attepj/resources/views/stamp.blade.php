@extends('default.index')

@push('css')
  <link rel="stylesheet" href="{{asset('css/stamp.css')}}">
@endpush

@section('content')
  <div class="stamp__item">
    <h2 class="name__item">{{Str::limit($user->name,10)}}さんお疲れ様です！</h2>
    <div class="button__item">
      <button class="attendance__button" id="atte__start" type="button" onclick="location.href='{{route('attendance.start')}}'">勤怠開始</button>
      <button class="attendance__button" id="atte__end" type="button" onclick="location.href='{{route('attendance.end')}}'">勤怠終了</button>
      <button class="attendance__button" id="rest__start" type="button" onclick="location.href='{{route('rest.start')}}'">休憩開始</button>
      <button class="attendance__button" id="rest__end" type="button" onclick="location.href='{{route('rest.end')}}'">休憩終了</button>
    </div>
  </div>
@endsection

@push('js')
  <script src="{{asset('js/stamp.js')}}"></script>
@endpush
