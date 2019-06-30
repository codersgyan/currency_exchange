    @extends('layouts.app')

    @section('content')
        <div class="container">
        	<div class="row">
        		<div class="col-md-12">
        			<ul class="list-group">
                        <li class="list-group-item active">Reports</li>
                        @forelse($items->items() as $item)
                        <li class="list-group-item"><a href="/storage/{{ $item }}" download>{{ $item }}</a></li>
                      @empty
                      @endforelse
                    </ul>
                    <div class="pagination mt-4">
                        {{ $items->links() }}
                    </div>
        		</div>
        	</div>
        </div>
    @endsection
