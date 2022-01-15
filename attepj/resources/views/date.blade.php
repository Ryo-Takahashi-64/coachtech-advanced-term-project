@extends('default.index')

@push('css')
  <link rel="stylesheet" href="{{asset('css/date.css')}}">
@endpush

@section('content')
    <h2 class="name__item">{{Str::limit($user->name,20)}}さん</h2>
    <div class="date__change__item">
      <div class="date__link__item">
        <a href="{{route('attendance',['ymItem' => $ymItem, 'ymRequest' => 'back'])}}"><</a>
      </div>
      <h2 class="date__item">{{$ymItem}}</h2>
      <div class="date__link__item">
        <a href="{{route('attendance',['ymItem' => $ymItem, 'ymRequest' => 'next'])}}">></a>
      </div>
    </div>
    <table>
      @isset($atteList[0])
      <tr>
        <th class="table__header">日付</th>
        <th class="table__header">勤務開始</th>
        <th class="table__header">勤務終了</th>
        <th class="table__header">休憩時間</th>
        <th class="table__header">勤務時間</th>
      </tr>
      @endisset
      @foreach($atteList as $item)
      <tr>
        <td class="table__desc">{{$item->attendance_date}}</td>
        <td class="table__desc">{{$item->work_start_time}}</td>
        <td class="table__desc">{{$item->work_end_time}}</td>
        <td class="table__desc">{{$item->total_break_time}}</td>
        <td class="table__desc">{{$item->total_work_time}}</td>
      </tr>
      @endforeach
    </table>
    {{$atteList->appends(request()->input())->links()}}
@endsection
