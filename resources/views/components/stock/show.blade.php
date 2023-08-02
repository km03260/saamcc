<div class="" style="padding:17px;background: beige;">
    <x-data-table list="mouvements" :vdata="$vdata" length="-1" :paging="false" classes="child" order="3"
        appends="article_id={{ $article->id }}" />
</div>
