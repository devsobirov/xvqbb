<h5>Bo'limlar kesimida topshiriq va jarayonlar yaratish ko'rsatkichlari</h5>
<p>Muddat: {{ \Carbon\Carbon::parse($from)->format('d-m-Y')}} dan - {{ \Carbon\Carbon::parse($to)->format('d-m-Y')}} gacha</p>
<p>Bo'lim: @if($currentDep = $departments->where('id', request('department_id'))->first()) {{$currentDep->name . " bo'limi"}} @else Barcha bo'limlar @endif </p>
<p>Bajarilgan sana: {{now()->format('d-m-Y h:i')}}</p>
<br>
<table>
    <thead>
    <tr>
        <th>№</th>
        <th>Bo'lim</th>
        <th>Topshiriqlar</th>
        <th>Jarayonlar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($departments->sortByDesc('tasks') as $department)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$department->name}}</td>
            <td>{{$department->tasks}} ta</td>
            <td>{{$department->processes}} ta</td>
        </tr>
    @endforeach
    </tbody>
</table>
