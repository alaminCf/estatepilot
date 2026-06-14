{{--
    Renders an installment amount as "Adjusted (Original: X)".

    Shows the adjusted figure as the primary number and, only when it differs
    from the originally configured installment, appends the original in a short,
    muted form. Works in both Tailwind and Bootstrap views (inline-styled).

    Params:
      $adjusted  - the live/adjusted per-installment value (preferred figure)
      $original  - the originally configured installment value
      $decimals  - decimal places (default 2)
--}}
@php
    $__orig = (float) ($original ?? 0);
    $__adj = (float) ($adjusted ?? 0);
    $__dec = $decimals ?? 2;
    $__shown = $__adj > 0 ? $__adj : $__orig;
    $__showOriginal = $__adj > 0 && abs($__adj - $__orig) > 0.01;
@endphp
৳{{ format_bd_number($__shown, $__dec) }}@if($__showOriginal) <span style="font-weight:400;opacity:.6;font-size:.82em;white-space:nowrap;">(Original: ৳{{ format_bd_number($__orig, $__dec) }})</span>@endif
