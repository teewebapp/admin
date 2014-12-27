@include('system::partials.validation')

{{ Form::resource($model, "admin.$resourceName", ['files' => true]) }}

    <div class="form-group">
        {{ Form::labelModel($model, 'title') }}
        {{ Form::text('title', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::labelModel($model, 'description') }}
        {{ Form::text('description', null, array('class' => 'form-control', 'rows' => 2)) }}
    </div>

    <div class="form-group">
        {{ Form::labelModel($model, 'url') }}
        {{ Form::text('url', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::labelModel($model, 'image') }}
        {{ Form::file('image', null, array('class' => 'form-control')) }}
    </div>

    {{ Form::submit($model->exists ? 'Editar' : 'Cadastrar', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}
