@extends('default.index')

@push('css')
  <link rel="stylesheet" href="{{asset('css/stamp.css')}}">
@endpush

@section('content')
  <div class="stamp__item">
    <h2 class="name__item">{{Str::limit($user->name,20)}}さん<span class="thanks__item">お疲れ様です！</span></h2>
    <div class="button__item">
      <a class="attendance__button" id="atte__start" href="{{route('attendance.start')}}">勤怠開始</a>
      <a class="attendance__button" id="atte__end" href="{{route('attendance.end')}}">勤怠終了</a>
      <a class="attendance__button" id="rest__start" href="{{route('rest.start')}}">休憩開始</a>
      <a class="attendance__button" id="rest__end" href="{{route('rest.end')}}">休憩終了</a>
    </div>
  </div>
@endsection

@push('js')
  <script>
    window.Laravel = {}
    window.Laravel.atte_flg = @json($atte_flg);
    window.Laravel.rest_flg = @json($rest_flg);
  </script>
  <script src="{{asset('js/stamp.js')}}"></script>
@endpush
