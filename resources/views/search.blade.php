
        @if(count($items))
        <table class="table table-striped">
          <thead>
            <tr>
              <td>item_name</td>
              <td>item_code</td>
              <td>item_price</td>
              <td>item_qty</td>
              <td>item_tax</td>
              <td>item_status</td>
            </tr>
          </thead>
          @foreach($items as $item)
            <tr>
              <td>{{$item->item_name}}</td>
              <td>{{$item->item_code}}</td>
              <td>{{$item->item_price}}</td>
              <td>{{$item->item_qty}}</td>
              <td>{{$item->item_tax}}</td>
              <td>{{$item->item_status}}</td>
            </tr>
          @endforeach
        </table>
        {{ $items->links() }}

        
        @endif
      </div>
    </div>
