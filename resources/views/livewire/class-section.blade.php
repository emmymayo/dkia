<div class="row">
    
        <div class="col-md-4">
        <label for="class_id">Class</label>
            <select  wire:model="section_class" class="form-control" wire:change="setSections" wire:change="$refresh" name="class_id">
                    <option value="">Select Class</option>
                @foreach ( $all_classes as $each_class )
                    <option  value="{{$each_class->id}}">{{$each_class->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
        <label for="section_id">Section <i wire:loading wire:target="setSections" class="fas fa-spin fa-spinner"> </i></label>
            <select  name="section_id" id="section" class="form-control"  >
                <option value=""></option>
                @if (!empty($sections))
                @foreach ( $sections as $section )
                    <option  value="{{$section->id}}">{{$section->name}}</option>
                @endforeach
                @endif
            </select>
            
        </div>
        
       
</div>
