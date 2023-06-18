<h5>Topshiriqlarni kechiktirmasdan bajarish bo'yicha ko'rsatkichlar</h5>
<p>Muddat: {{ \Carbon\Carbon::parse($from)->format('d-m-Y')}} dan - {{ \Carbon\Carbon::parse($to)->format('d-m-Y')}} gacha</p>
<p>Bo'lim: @if($currentDep = $departments->where('id', request('department_id'))->first()) {{$currentDep->name . " bo'limi"}} @else Barcha bo'limlar @endif </p>
<p>Bajarilgan sana: {{now()->format('d-m-Y h:i')}}</p>
<br>
<table>
    <thead>
    <tr>
        <th>№</th>
        <th>Filial</th>
        <th>Kechikmagan - %</th>
        <th>Kechikmagan - soni</th>
        <th>Jami topshiriqlar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($branches->sortByDesc('validity') as $branch)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$branch->name}}</td>
            <td>{{$branch->validity}} %</td>
            <td>{{$branch->valid}} ta</td>
            <td>{{$branch->total}} ta</td>
        </tr>
    @endforeach
    </tbody>
</table>
