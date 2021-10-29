<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>

@if(isset($module) && $module)
    @stack('module-js')
@else
    <script src="{{mix('js/admin.js')}}"></script>
@endif


@include('admin.layout.parts.websocket')
<script>
    $(window).on('load', function () {
        $('#layout-wrapper').fadeIn();
    })
</script>
