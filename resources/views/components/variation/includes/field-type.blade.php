@switch($type)
    @case('text')
    @break

    @case('texte')
    @break

    @case('nombre')
    @break

    @case('décimale')
    @break

    @case('options')
        <div class="two fields fieldControl value_F">
            <div class="two wide field" style="margin: auto">
                <label>Options </label>
            </div>
            <div class="fourteen wide field">
                <x-includes.dropdown name="value" classes="{{ $vdata }}_value" value=""
                    placeholder="Options possibles" :vdata="$vdata" :push="false"
                    url="{{ Route('handle.select', 'empty') }}" :allowAdditions="true" styles="" :multiple="true" />
                <div class="msgError value_M"></div>
            </div>
        </div>
    @break

    @default
@endswitch

<div class="two fields fieldControl default_F">
    <div class="two wide field" style="margin: auto">
        <label>Défaut </label>
    </div>
    <div class="fourteen wide field">
        <input type="text" name="default" placeholder="Valeur par défaut...">
        <div class="msgError default_M"></div>
    </div>
</div>
