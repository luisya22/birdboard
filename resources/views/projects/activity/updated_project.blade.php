@if(count($activity->changes['after']) == 1)
    {{$activity->username()}} updated the {{key($activity->changes['after'])}} of the project
@else
    {{$activity->username()}} updated the project
@endif
