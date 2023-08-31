@can('delete', [$_model::class, $_model])
    <div class="load-model ui mini blue icon button" data-url="{{ Route('user.resetPassword', $_model->id) }}"
        data-title="<img src='{{ asset('assets/images/app_logo_sq.png') }}' height='20px' /> <span style='vertical-align: super;'>&nbsp;Réinitialiser le mot
    de passe</span>"
        data-color="#2185d0" data-width="650px" style="padding:5px 11px;"><i class="key icon"></i>&nbsp;Réinitialiser le mot
        de passe</div>
@endcan
