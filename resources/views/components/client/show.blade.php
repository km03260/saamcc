    <x-tab name="client_menu-{{ $vdata }}" url="{{ Route('client.show', [$client->id]) }}?tab={tab}"
        :tabs="$tabs" />
