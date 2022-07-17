<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" placeholder="{{ $placeholder }}">
</div>
