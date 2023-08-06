<div>
    @can('update', [$_model::class, $_model])
        <div class="ui form form_field" data-id="{{ $_model->id }}"
            data-url="{{ Route('commande.update', $_model->id) }}?methode=savewhat&noClicked=true&commande">
            <div class="field">
                <textarea class="up_field" data-name="commentaire" cols="80" rows="7" placeholder="Commentaire"
                    style="width:100%; border:0">{!! $_model->commentaire !!}</textarea>
            </div>
        </div>
    @endcan
    @cannot('update', [$_model::class, $_model])
        <textarea readonly cols="80" rows="7" style="width:100%; border:0">{!! $_model->commentaire !!}</textarea>
    @endcannot
</div>
