<div>
<div class="form-group col-md-4">
                    <label for="state_id">State </label>
                    <select class="form-control" wire:model="state_id"  wire:change="setLga" name="state_id" id="state_id" >
                        <option value=""> Select State</option>
                        @foreach ($states as $state )
                        <option  value="{{$state->id}}"> {{$state->name}}</option> 
                        @endforeach
                    </select>
                    
                  </div>

                  <div class="form-group col-md-4">
                    <label for="lga">LGA <i wire:loading wire:target="setLga" class="fas fa-spin fa-spinner"> </i> </label>
                    <select class="form-control"   name="lga_id" id="lga_id" >
                      
                      @empty ($lgas)  
                        <option value=""> Select State First</option>
                      @endempty
                      <option value=""></option>
                      @if (!empty($lgas))
                        @foreach ($lgas as $lga )
                        <option  value="{{$lga->id}}"> {{$lga->name}}</option> 
                        @endforeach
                      @endif
                    </select>
                    
                  </div>
</div>
