<section class="chart">
    <div class="hv-container">
        <div class="hv-wrapper">
            <div class="hv-item">
                <div class="hv-item-parent">
                    <div class="simple-card node root"> 
                        <p>{{ $root['name'] }} </p>
                    </div>      
                </div>
                <div class="hv-item-children">
                    @foreach($children as $child)
                    <div class="hv-item-child">
                        @if($child['status'] == 0)
                        <div class="simple-card node unexpend child-node " id="{{ $child['id'] }}" data-username="{{ $child['username'] }}"> 
                            <p><span style="color:red;">{{ $child['tree_level_name'] }}</span> | {{ $child['name'] }} |  <span style="color:red;">{{ $child['subs_count'] }}</span></p>
                            <p>{{ $child['username'] }} </p>       
                            <p>{{ $child['member_number'] }} </p>       
                        </div>
                        @else
                        <div class="simple-card node place-node" id="{{ $child['id'] }}"> 

                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>