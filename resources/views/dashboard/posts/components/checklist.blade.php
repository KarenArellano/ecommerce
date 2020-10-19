@foreach (data_get($block, 'data.items') as $item)
<div class="form-check">
	<label class="form-check-label">
		<input type="checkbox" class="form-check-input" disabled style="margin-top: -8px;" {{ $item['checked'] ? 'checked' : ''}}>
		{!! $item['text'] !!}
	</label>
</div>
@endforeach
