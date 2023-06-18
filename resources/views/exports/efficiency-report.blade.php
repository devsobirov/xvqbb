<h5>Jamg'arilgan ballar (unumdorlik) bo'yicha hisobot</h5>
<p>Muddat: {{ \Carbon\Carbon::parse($from)->format('d-m-Y')}} dan - {{ \Carbon\Carbon::parse($to)->format('d-m-Y')}} gacha</p>
<p>Bo'lim: @if($currentDep = $departments->where('id', request('department_id'))->first()) {{$currentDep->name . " bo'limi"}} @else Barcha bo'limlar @endif </p>
<p>Bajarilgan sana: {{now()->format('d-m-Y h:i')}}</p>
<br>
<table>
    <thead>
        <tr>
            <th>№</th>
            <th>Filial</th>
            <th>Jami topshiriqlar soni</th>
            <th>Jamg'arilgan ball</th>
        </tr>
    </thead>
    <tbody>
    @foreach($branches as $branch)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$branch->name}}</td>
            <td>{{$branch->total}} ta</td>
            <td>{{is_numeric($branch->score) ? ($branch->score . ' ball') : '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
