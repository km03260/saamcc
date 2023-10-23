@extends('layouts.app')

@section('content')
    <div style="margin:17px">
        <div class="ui form form_field" data-id="{{ $commande->id }}"
            data-url="{{ Route('commande.update', $commande->id) }}?methode=savewhat&noClicked=true&commande">
            <table class="ui celled striped table" style="border:1px solid #ccc !important">
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <td width="175px" style="padding: 3px 11px"> Commande N° </td>
                        <td>{{ $commande->id }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 11px"> Statut </td>
                        <td> {{ $commande->statut->designation }} </td>
                    </tr>
                    @if (in_array($commande->statut_id, [1, 2]))
                        <tr>
                            <td style="padding: 3px 11px"> Semain de livraison </td>
                            <td> {{ $commande->date_livraison_souhaitee ? Carbon\Carbon::parse($commande->date_livraison_souhaitee)->format('W/Y') : '' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td style="padding: 3px 11px"> Semaine de livraison </td>
                            <td> {{ $commande->date_livraison_confirmee ? Carbon\Carbon::parse($commande->date_livraison_confirmee)->format('W/Y') : '' }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 3px 11px"> N°Commande MagiSoft </td>
                        <td>{{ $commande->ccnum }} </td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 11px"> N°Commande Client </td>
                        <td>{{ $commande->ncmd_cli }} </td>
                    </tr>
                    <tr>
                        <td style="padding: 3px 11px"> Intitulé </td>
                        <td>{{ $commande->intitule }} </td>
                    </tr>
                    <tr>
                        <td> Commentaire </td>
                        <td>{!! $commande->commentaire !!} </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="">
                            Créé Le {{ Carbon\Carbon::parse($commande->cree_le)->format('d/m/Y') }} Par
                            {{ $commande->user?->Prenom }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        @if ($commande->articles->count() > 0)
            <strong>Articles:</strong>
            <table class="ui celled striped table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Référence</th>
                        <th>Désignation</th>
                        {{-- <th style="text-align:center">Prix unitaire</th> --}}
                        <th style="text-align:center">Quantité</th>
                        {{-- <th style="text-align:center">Total</th> --}}
                    </tr>
                </thead>

                <tbody>
                    @foreach ($commande->articles as $art)
                        <tr>
                            <td>{{ $art->id }}</td>
                            <td>{{ $art->article->ref }}</td>
                            <td>{{ $art->article->designation }}</td>
                            {{-- <td style="text-align: right">{{ $art->pu }}</td> --}}
                            <td style="text-align: right">{{ $art->qty }}</td>
                            {{-- <td style="text-align: right">{{ $art->qty * $art->pu }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            window.print()
        })
        window.onbeforeprint = function() {};
        window.onafterprint = function() {
            window.close()
        };
    </script>
@endsection
