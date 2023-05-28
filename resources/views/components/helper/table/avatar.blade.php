@props([
    'image' => null,
    'name' => '',
    'size' => 'md',
    'class' => '',
    'rounded' => true,
])

<div @class(['avatar', 'avatar-' . $size, $class => $class])>
    <img data-action-preview src="{{ $image ? asset($image) : 'https://via.placeholder.com/150' }}"
        alt="{{ $name }}" @class([
            'avatar-img rounded-circle' => $rounded,
            'avatar-img' => !$rounded,
        ])>
</div>
