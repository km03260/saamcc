@include('layouts.partials.header')

@include('layouts.partials.dmin-menu')

@include('layouts.partials.adm-content')

@include('layouts.partials.footer')

<script>
    $('.ui.dropdown').dropdown();
    $(document).ready(function() {
        $('.sidebar-menu-toggler').on('click', function() {
            var target = $(this).data('target');
            $(target).sidebar({
                dinPage: true,
                transition: 'overlay',
                mobileTransition: 'overlay'
            }).sidebar('toggle');
        });

    });
</script>
