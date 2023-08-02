 <tr>
     @foreach ($columns as $column)
         <th style="padding-right: 21px">
             @if (isset($column['view']))
                 @include($column['view'], $params)
             @else
                 {{ $column['name'] }}
             @endif
         </th>
     @endforeach
 </tr>
