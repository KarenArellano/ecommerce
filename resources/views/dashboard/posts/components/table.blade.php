<div class="table-responsive">
    <table class="table table-borderless">
        <thead class="thead-light">
            <tr>
                @foreach (data_get($block, 'data.content.0') as $row)
                <th scope="col">{!! $row !!}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
         <tr>
            @foreach (collect(data_get($block, 'data.content'))->filter(function($item, $key){return $key != 0;}) as $rows)
            @foreach ($rows as $column)
            <th scope="row">{!! $column !!}</th>
            @endforeach
            @endforeach
        </tr>
    </tbody>
</table>
</div>
