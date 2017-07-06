<form method="POST" action="#" role="form" accept-charset="utf-8">
    {{ csrf_field() }}
    <fieldset class="form-group{{ $errors->has('iso') ? ' has-danger' : '' }}">
        <label for="iso" class="sr-only">ISO Code</label>
        <input id="iso" type="text" class="form-control" name="iso" value="{{ old('iso') }}" placeholder="ISO Country" required>
        @if ($errors->has('iso'))
            <section class="form-control-feedback">{{ $errors->first('iso') }}</section>
        @endif
    </fieldset>
    <fieldset class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        <label for="name" class="sr-only">Name</label>
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required>
        @if ($errors->has('name'))
            <section class="form-control-feedback">{{ $errors->first('name') }}</section>
        @endif
    </fieldset>
    <section class="form-group">
        <button type="submit" class="btn btn-block btn-primary" role="button">Save</button>
    </section>
</form>