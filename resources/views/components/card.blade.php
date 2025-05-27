@props(['department'=> null, 'buttonText' => 'Click Here'])

<div @class(['CSE'=> $department, 'card'])>

    {{$slot}}
    <a {{$attributes}}>
        {{ $buttonText }}
    </a>

</div>