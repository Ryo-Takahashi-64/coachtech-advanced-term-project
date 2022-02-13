@extends('default.index')

@push('css')
  <link rel="stylesheet" href="{{asset('css/attendance.css')}}">
@endpush

@section('content')
    <h2 class="name__item"></h2>
    <div class="date__change__item">
      <div class="date__link__item">
        <a id="back__item" href="{{route('attendance.user',['ymdItem' => $ymdItem, 'ymdRequest' => 'back'])}}"><</a>
      </div>
      <h2 class="date__item">{{$ymdItem}}</h2>
      <div class="date__link__item">
        <a id="next__item" href="{{route('attendance.user',['ymdItem' => $ymdItem, 'ymdRequest' => 'next'])}}">></a>
      </div>
    </div>
    <table>
      @isset($atteList[0])
      <tr>
        <th class="table__header">名前</th>
        <th class="table__header">勤務開始</th>
        <th class="table__header">勤務終了</th>
        <th class="table__header">休憩時間</th>
        <th class="table__header">勤務時間</th>
      </tr>
      @endisset
      @foreach($atteList as $item)
      <tr>
        <td class="table__desc">{{Str::limit($item->name,20)}}</td>
        <td class="table__desc">{{$item->work_start_time}}</td>
        <td class="table__desc">{{$item->work_end_time}}</td>
        <td class="table__desc">{{$item->total_break_time}}</td>
        <td class="table__desc">{{$item->total_work_time}}</td>
      </tr>
      @endforeach
    </table>
    {{$atteList->appends(request()->input())->links()}}
@endsection

@push('js')
  <script>
    window.Laravel = {}
    window.Laravel.oldestFlg = @json($oldestFlg);
    window.Laravel.latestFlg = @json($latestFlg);
  </script>
  <script src="{{asset('js/attendance.js')}}"></script>
@endpush

