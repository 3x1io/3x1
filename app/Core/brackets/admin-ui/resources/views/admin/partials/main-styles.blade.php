<link href="{{ mix('/css/admin.css') }}" rel="stylesheet">
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<style>
    .loading-full {
        width: 100% !important;
        height: 100% !important;
        background: rgba(255,255,255, 1) !important;
        z-index: 9999999;
        position: fixed;
        @if(auth('admin')->user() && auth('admin')->user()->language === 'ar')

        left:50%;
        right:0;
        @else
        left:0;
        right:50%;
        @endif
        top:0;
        bottom:50%;
        margin: 0 !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
