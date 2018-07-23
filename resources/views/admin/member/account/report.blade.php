
<table >
    <tbody>
    <tr>
        <th>資料id</th>
        <th>時間</th>
        <th>會員帳號</th>
        <th>會員名稱</th>
        <th>帳戶類型</th>
        <th>轉出</th>
        <th>轉入</th>
        <th>餘額</th>
        <th>類型</th>
        <th>說明</th>
    </tr>
    @foreach($datas as $data)
    <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->created_at }}</td>
        <td>{{ $data->username }}</td>
        <td>{{ $data->name }}</td>
        <td>{{ config('member.account.type.'.$data->account_type) }}</td>
        <td>@if($data->amount < 0){{ abs($data->amount) }}@endif</td>
        <td>@if($data->amount >= 0){{ $data->amount }}@endif</td>
        <td>{{ $data->total }}</td>
        <td>{{ config('member.account.transfer_type.'.$data->type) }}</td>
        <td>{{ $data->description }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
