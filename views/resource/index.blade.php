@extends('admin::layouts.main')

{{ Tee\System\Asset::add(moduleAsset('admin', 'js/tableorder.js')) }}

@section('content')
    <table class="table table-hover table-banner-list">
        <tbody>
            <tr>
                @if($orderable)
                    <td>
                        &nbsp;
                    </td>
                @endif
                @foreach($tableColumns as $column)
                    <th>{{{ attributeName($modelClass, $column) }}}</th>
                @endforeach
                <th>Opções</th>
            </tr>
        
            @if($models->count() > 0)
                @foreach($models as $model)
                    <tr data-id="{{{ $model->id }}}">

                        @if($orderable)
                            <td>
                                <div style="float:left;">
                                    <a href="javascript:void(0)" class="glyphicon glyphicon-chevron-up" ></a>
                                    <a href="javascript:void(0)" class="glyphicon glyphicon-chevron-down" ></a>
                                    &nbsp;
                                </div>
                            </td>
                        @endif

                        @foreach($tableColumns as $column)
                            <td>{{{ $model->$column }}}</td>
                        @endforeach

                        <td>
                            {{ HTML::updateButton('Editar', route("admin.$resourceName.edit", $model->id)) }}
                            {{ HTML::deleteButton('Remover', route("admin.$resourceName.destroy", $model->id)) }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">
                        Nenhuma item cadastrado
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <a class="btn btn-primary" href="{{ route("admin.$resourceName.create") }}">
        Adicionar Item
    </a>

    @if($orderable)
        <script type="text/javascript">
            $(document).ready(function() {
                $('.table-banner-list').tableOrder({
                    itens: 'tbody tr',
                    up: '.glyphicon-chevron-up',
                    down: '.glyphicon-chevron-down',
                    url: '{{ route("admin.$resourceName.order") }}'
                });
            });
        </script>
    @endif
@stop